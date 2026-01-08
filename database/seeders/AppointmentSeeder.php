<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Appointment;
use App\Models\Client;
use App\Models\Order;
use Carbon\Carbon;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        $clients = Client::all();

        if ($clients->count() === 0) {
            $this->command->warn('No clients found. Please run ClientSeeder first.');
            return;
        }

        $colors = ['#d4b896', '#ec4899', '#9333ea', '#3b82f6', '#22c55e', '#14b8a6'];

        $appointments = [
            // December 28
            [
                'client_id' => 7,
                'order_id' => null,
                'title' => 'Akad Nikah di Rumah',
                'description' => 'Akad nikah dan makeup pengantin',
                'date' => Carbon::create(2025, 12, 28),
                'start_time' => '08:00',
                'end_time' => '12:00',
                'color' => $colors[2], // purple
            ],
            [
                'client_id' => 7,
                'order_id' => null,
                'title' => 'Resepsi Pernikahan',
                'description' => 'Resepsi pernikahan siang hari',
                'date' => Carbon::create(2025, 12, 28),
                'start_time' => '13:00',
                'end_time' => '17:00',
                'color' => $colors[1], // pink
            ],
            // December 29
            [
                'client_id' => 8,
                'order_id' => null,
                'title' => 'Akad Nikah',
                'description' => 'Akad nikah pagi',
                'date' => Carbon::create(2025, 12, 29),
                'start_time' => '09:00',
                'end_time' => '11:00',
                'color' => $colors[2], // purple
            ],
            [
                'client_id' => 8,
                'order_id' => null,
                'title' => 'Resepsi',
                'description' => 'Resepsi pernikahan',
                'date' => Carbon::create(2025, 12, 29),
                'start_time' => '14:00',
                'end_time' => '18:00',
                'color' => $colors[1], // pink
            ],
            // January 3 - Client 1 has order
            [
                'client_id' => 1,
                'order_id' => 1, // ORD-001
                'title' => 'Akad Nikah di Coba',
                'description' => 'Akad nikah Devi olivia',
                'date' => Carbon::create(2026, 1, 3),
                'start_time' => '08:00',
                'end_time' => '10:00',
                'color' => $colors[2], // purple
            ],
            [
                'client_id' => 1,
                'order_id' => 1, // ORD-001
                'title' => 'Resepsi Pernikahan di Coba',
                'description' => 'Resepsi pernikahan Devi olivia',
                'date' => Carbon::create(2026, 1, 3),
                'start_time' => '16:00',
                'end_time' => '17:12',
                'color' => $colors[1], // pink
            ],
            [
                'client_id' => 9,
                'order_id' => null,
                'title' => 'Coba',
                'description' => 'Testing appointment',
                'date' => Carbon::create(2026, 1, 3),
                'start_time' => '10:00',
                'end_time' => '12:00',
                'color' => $colors[2], // purple
            ],
            [
                'client_id' => 9,
                'order_id' => null,
                'title' => 'Coba',
                'description' => 'Testing appointment 2',
                'date' => Carbon::create(2026, 1, 3),
                'start_time' => '14:00',
                'end_time' => '16:00',
                'color' => $colors[1], // pink
            ],
            // January 4 - Client 3 has order, Client 4 has order
            [
                'client_id' => 3,
                'order_id' => 3, // ORD-003
                'title' => 'Susiyanti & Ahmad sukron',
                'description' => 'Akad nikah',
                'date' => Carbon::create(2026, 1, 4),
                'start_time' => '09:00',
                'end_time' => '11:00',
                'color' => $colors[2], // purple
            ],
            [
                'client_id' => 4,
                'order_id' => 4, // ORD-004
                'title' => 'Syafa\'atul maula & Adi nurhadi',
                'description' => 'Akad nikah',
                'date' => Carbon::create(2026, 1, 4),
                'start_time' => '13:00',
                'end_time' => '15:00',
                'color' => $colors[2], // purple
            ],
            // January 5 - Client 5 has order
            [
                'client_id' => 5,
                'order_id' => 5, // ORD-005
                'title' => 'Siti & Intan',
                'description' => 'Akad nikah',
                'date' => Carbon::create(2026, 1, 5),
                'start_time' => '08:00',
                'end_time' => '10:00',
                'color' => $colors[2], // purple
            ],
            [
                'client_id' => 5,
                'order_id' => 5, // ORD-005
                'title' => 'Intan',
                'description' => 'Resepsi',
                'date' => Carbon::create(2026, 1, 5),
                'start_time' => '14:00',
                'end_time' => '16:00',
                'color' => $colors[1], // pink
            ],
            // January 6
            [
                'client_id' => 6,
                'order_id' => null,
                'title' => 'Indah',
                'description' => 'Akad nikah',
                'date' => Carbon::create(2026, 1, 6),
                'start_time' => '09:00',
                'end_time' => '11:00',
                'color' => $colors[2], // purple
            ],
            // January 7
            [
                'client_id' => 6,
                'order_id' => null,
                'title' => 'Indah',
                'description' => 'Resepsi',
                'date' => Carbon::create(2026, 1, 7),
                'start_time' => '10:00',
                'end_time' => '12:00',
                'color' => $colors[1], // pink
            ],
            // January 9 - Client 10 has order_id 2
            [
                'client_id' => 10,
                'order_id' => 2, // ORD-002
                'title' => 'Suchi',
                'description' => 'Akad nikah',
                'date' => Carbon::create(2026, 1, 9),
                'start_time' => '08:00',
                'end_time' => '10:00',
                'color' => $colors[2], // purple
            ],
            [
                'client_id' => 10,
                'order_id' => 2, // ORD-002
                'title' => 'Suchi',
                'description' => 'Resepsi',
                'date' => Carbon::create(2026, 1, 9),
                'start_time' => '13:00',
                'end_time' => '15:00',
                'color' => $colors[1], // pink
            ],
            // January 10
            [
                'client_id' => 11,
                'order_id' => null,
                'title' => 'Saripah',
                'description' => 'Akad nikah',
                'date' => Carbon::create(2026, 1, 10),
                'start_time' => '09:00',
                'end_time' => '11:00',
                'color' => $colors[2], // purple
            ],
            [
                'client_id' => 11,
                'order_id' => null,
                'title' => 'Saripah',
                'description' => 'Resepsi',
                'date' => Carbon::create(2026, 1, 10),
                'start_time' => '14:00',
                'end_time' => '16:00',
                'color' => $colors[1], // pink
            ],
            // January 11
            [
                'client_id' => 14,
                'order_id' => null,
                'title' => 'Salsabilla',
                'description' => 'Akad nikah',
                'date' => Carbon::create(2026, 1, 11),
                'start_time' => '08:00',
                'end_time' => '10:00',
                'color' => $colors[2], // purple
            ],
            [
                'client_id' => 14,
                'order_id' => null,
                'title' => 'Salsabilla',
                'description' => 'Resepsi',
                'date' => Carbon::create(2026, 1, 11),
                'start_time' => '13:00',
                'end_time' => '15:00',
                'color' => $colors[2], // purple
            ],
            // January 16
            [
                'client_id' => 12,
                'order_id' => null,
                'title' => 'Indriyani',
                'description' => 'Akad nikah',
                'date' => Carbon::create(2026, 1, 16),
                'start_time' => '09:00',
                'end_time' => '11:00',
                'color' => $colors[1], // pink
            ],
            [
                'client_id' => 12,
                'order_id' => null,
                'title' => 'Indriyani',
                'description' => 'Resepsi',
                'date' => Carbon::create(2026, 1, 16),
                'start_time' => '14:00',
                'end_time' => '16:00',
                'color' => $colors[1], // pink
            ],
            // January 17
            [
                'client_id' => 13,
                'order_id' => null,
                'title' => 'Bina',
                'description' => 'Akad nikah',
                'date' => Carbon::create(2026, 1, 17),
                'start_time' => '08:00',
                'end_time' => '10:00',
                'color' => $colors[2], // purple
            ],
            [
                'client_id' => 13,
                'order_id' => null,
                'title' => 'Ananda',
                'description' => 'Resepsi',
                'date' => Carbon::create(2026, 1, 17),
                'start_time' => '13:00',
                'end_time' => '15:00',
                'color' => $colors[2], // purple
            ],
        ];

        foreach ($appointments as $appointmentData) {
            if ($appointmentData['client_id'] <= $clients->count()) {
                Appointment::create($appointmentData);
            }
        }
    }
}
