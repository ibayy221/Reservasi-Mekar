<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Event::create([
            'title' => 'Pernikahan',
            'description' => 'Rayakan hari istimewa Anda di ballroom mewah kami dengan kapasitas hingga 500 tamu dan dekorasi elegan.',
            'image_path' => 'Asset/Facilities and facade building/Waiting room.jpg',
            'badge' => 'Populer',
            'badge_color' => 'purple',
            'features' => ['Ballroom', 'Catering'],
            'slug' => 'pernikahan',
            'order' => 1,
        ]);

        Event::create([
            'title' => 'Seminar & Konferensi',
            'description' => 'Fasilitas meeting room modern dengan teknologi audiovisual terkini, cocok untuk seminar dan acara bisnis profesional.',
            'image_path' => 'Asset/Facilities and facade building/Waiting room.jpg',
            'badge' => 'Profesional',
            'badge_color' => 'blue',
            'features' => ['Meeting Rooms', 'WiFi Premium'],
            'slug' => 'seminar-konferensi',
            'order' => 2,
        ]);

        Event::create([
            'title' => 'Kids Activity',
            'description' => 'Area bermain anak yang aman dan menyenangkan dengan berbagai aktivitas edukatif yang dirancang khusus untuk keluarga.',
            'image_path' => 'Asset/Facilities and facade building/Waiting room.jpg',
            'badge' => 'Keluarga',
            'badge_color' => 'pink',
            'features' => ['Kids Club', 'Family Zone'],
            'slug' => 'kids-activity',
            'order' => 3,
        ]);
    }
}
