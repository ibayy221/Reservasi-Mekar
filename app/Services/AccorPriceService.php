<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class AccorPriceService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client(["timeout" => 10]);
    }

    /**
     * Fetch prices from an Accor hotel booking page.
     * Attempts to find price strings (e.g. "Rp 1.000.000") near room headings.
     * Returns associative array keyed by room key provided.
     */
    public function fetchPrices(string $url, array $roomKeys, int $cacheMinutes = 30): array
    {
        $cacheKey = 'accor_prices_' . md5($url . implode(',', $roomKeys));
        return Cache::remember($cacheKey, now()->addMinutes($cacheMinutes), function () use ($url, $roomKeys) {
            try {
                $res = $this->client->get($url, [
                    'headers' => [
                        'User-Agent' => 'Mozilla/5.0 (compatible; mbooking-bot/1.0)'
                    ]
                ]);
                $html = (string) $res->getBody();
            } catch (\Throwable $e) {
                return [];
            }

            $prices = [];

            foreach ($roomKeys as $key => $search) {
                // find the position of the room heading
                $pos = stripos($html, $search);
                if ($pos === false) {
                    $prices[$key] = null;
                    continue;
                }

                // examine a window of html after the heading to search for price
                $snippet = substr($html, $pos, 2000);

                // regex for Indonesian rupiah like "Rp 1.234.567"
                if (preg_match('/Rp\s*[0-9\.,]+/u', $snippet, $m)) {
                    $prices[$key] = trim($m[0]);
                    continue;
                }

                // fallback: look for numbers with currency code
                if (preg_match('/IDR\s*[0-9\.,]+/u', $snippet, $m2)) {
                    $prices[$key] = trim($m2[0]);
                    continue;
                }

                $prices[$key] = null;
            }

            return $prices;
        });
    }
}
