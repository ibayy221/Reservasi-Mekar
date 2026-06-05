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
        Kamar::create([
            'name' => 'Deluxe Room',
            'slug' => 'deluxe-room',
            'price' => 450000,
            'capacity' => 2,
            'stock' => 5,
            'description' => 'Kamar yang nyaman dengan satu tempat tidur king-size.',
            'image' => 'Asset/Room images/Deluxe 1 king bed/Deluxe 1 king bed.jpg',
        ]);

        Kamar::create([
            'name' => 'Executive Suite',
            'slug' => 'executive-suite',
            'price' => 850000,
            'capacity' => 3,
            'stock' => 2,
            'description' => 'Suite eksklusif dengan area kerja dan sofa.',
            'image' => 'Asset/Room images/Suite business 1 king bed and sofa/Suite business 1 king bed and sofa.jpg',
        ]);

        Kamar::create([
            'name' => 'Superior Room',
            'slug' => 'superior-room',
            'price' => 350000,
            'capacity' => 2,
            'stock' => 8,
            'description' => 'Kamar premium dengan fasilitas lengkap.',
            'image' => 'Asset/Room images/Superior 1 king bed/Kamar-supperior 1 king bed.jpg',
        ]);
    }
}
