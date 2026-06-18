<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kamar;
use App\Models\KamarAvailability;
use App\Models\Reservasi;
use Carbon\Carbon;

class KamarAvailabilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $days = 365; // default days to seed
        $start = Carbon::today();

        $kamars = Kamar::all();
        foreach ($kamars as $kamar) {
            $this->command->info("Seeding availability for kamar: {$kamar->id} ({$kamar->name})");

            for ($i = 0; $i < $days; $i++) {
                $date = $start->copy()->addDays($i)->toDateString();

                // count existing reservations that overlap this date
                $reserved = Reservasi::where('kamar_id', $kamar->id)
                    ->whereDate('check_in', '<=', $date)
                    ->whereDate('check_out', '>', $date)
                    ->where('status', '!=', 'cancelled')
                    ->count();

                $available = max(0, $kamar->stock - $reserved);

                KamarAvailability::updateOrCreate(
                    ['kamar_id' => $kamar->id, 'date' => $date],
                    ['available' => $available]
                );
            }
        }

        $this->command->info('Kamar availability seeding completed.');
    }
}
