<?php

namespace Database\Seeders;

use App\Models\Kamar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KamarSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $rooms = [
            [
                'name' => 'Deluxe Room 2 King Size',
                'slug' => 'deluxe-room-2-king-size',
                'price' => 650000,
                'capacity' => 4,
                'stock' => 3,
                'description' => 'Deluxe room dengan 2 tempat tidur king size untuk keluarga atau tamu grup.',
                'image' => 'Asset/Room images/Deluxe 1 king bed/Deluxe 1 king bed.jpg',
            ],
            [
                'name' => 'Deluxe Room Twin Bed',
                'slug' => 'deluxe-room-twin-bed',
                'price' => 580000,
                'capacity' => 2,
                'stock' => 4,
                'description' => 'Deluxe room nyaman dengan 2 tempat tidur twin yang ideal untuk tamu bisnis.',
                'image' => 'Asset/Room images/Deluxe 1 king bed/Deluxe 1 king bed.jpg',
            ],
            [
                'name' => 'Executive Suite',
                'slug' => 'executive-suite',
                'price' => 850000,
                'capacity' => 3,
                'stock' => 2,
                'description' => 'Suite eksklusif dengan area kerja dan sofa.',
                'image' => 'Asset/Room images/Suite business 1 king bed and sofa/Suite business 1 king bed and sofa.jpg',
            ],
            [
                'name' => 'Family Room',
                'slug' => 'family-room',
                'price' => 750000,
                'capacity' => 5,
                'stock' => 2,
                'description' => 'Kamar keluarga luas dengan 2 tempat tidur queen dan area santai.',
                'image' => 'Asset/Room images/Suite business 1 king bed and sofa/Suite business 1 king bed and sofa.jpg',
            ],
            [
                'name' => 'Superior Room',
                'slug' => 'superior-room',
                'price' => 350000,
                'capacity' => 2,
                'stock' => 8,
                'description' => 'Kamar premium dengan fasilitas lengkap.',
                'image' => 'Asset/Room images/Superior 1 king bed/Kamar-supperior 1 king bed.jpg',
            ],
            [
                'name' => 'Junior Suite',
                'slug' => 'junior-suite',
                'price' => 950000,
                'capacity' => 3,
                'stock' => 1,
                'description' => 'Junior suite mewah dengan pemandangan kota dan ruang tamu mini.',
                'image' => 'Asset/Room images/Suite business 1 king bed and sofa/Suite business 1 king bed and sofa.jpg',
            ],
        ];

        foreach ($rooms as $room) {
            Kamar::firstOrCreate(
                ['slug' => $room['slug']],
                $room
            );
        }
    }
}
