<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;
use Carbon\Carbon;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $clients = [
            [
                'bride_name' => 'Devi olivia',
                'groom_name' => 'Agus suhendra',
                'bride_phone' => '081234567890',
                'groom_phone' => '081234567891',
                'akad_date' => Carbon::create(2026, 1, 3),
                'reception_date' => Carbon::create(2026, 1, 3),
                'event_location' => 'Gedung Serbaguna Merpati, Jl. Merpati No.10, Jakarta'
            ],
            [
                'bride_name' => 'Fitria',
                'groom_name' => 'Ahmad fatkhurojak',
                'bride_phone' => '081234567892',
                'groom_phone' => '081234567893',
                'akad_date' => Carbon::create(2026, 1, 3),
                'reception_date' => Carbon::create(2026, 1, 3),
                'event_location' => 'Balai Kartini, Jl. Gatot Subroto No.37, Jakarta'
            ],
            [
                'bride_name' => 'Susiyanti',
                'groom_name' => 'Ahmad sukron',
                'bride_phone' => '081234567894',
                'groom_phone' => '081234567895',
                'akad_date' => Carbon::create(2026, 1, 4),
                'reception_date' => Carbon::create(2026, 1, 4),
                'event_location' => 'Gedung Serbaguna Merpati, Jl. Merpati No.10, Jakarta'
            ],
            [
                'bride_name' => 'Syafa\'atul maula',
                'groom_name' => 'Adi nurhadi',
                'bride_phone' => '081234567896',
                'groom_phone' => '081234567897',
                'akad_date' => Carbon::create(2026, 1, 4),
                'reception_date' => Carbon::create(2026, 1, 4),
                'event_location' => 'Balai Kartini, Jl. Gatot Subroto No.37, Jakarta'
            ],
            [
                'bride_name' => 'Siti',
                'groom_name' => 'Intan',
                'bride_phone' => '081234567898',
                'groom_phone' => '081234567899',
                'akad_date' => Carbon::create(2026, 1, 5),
                'reception_date' => Carbon::create(2026, 1, 5),
                'event_location' => 'Gedung Serbaguna Merpati, Jl. Merpati No.10, Jakarta'
            ],
            [
                'bride_name' => 'Indah',
                'groom_name' => 'Sekar',
                'bride_phone' => '081234567800',
                'groom_phone' => '081234567801',
                'akad_date' => Carbon::create(2026, 1, 6),
                'reception_date' => Carbon::create(2026, 1, 6),
                'event_location' => 'Gedung Serbaguna Merpati, Jl. Merpati No.10, Jakarta'
            ],
            [
                'bride_name' => 'Nurfadila',
                'groom_name' => 'Romiah',
                'bride_phone' => '081234567802',
                'groom_phone' => '081234567803',
                'akad_date' => Carbon::create(2025, 12, 28),
                'reception_date' => Carbon::create(2025, 12, 28),
                'event_location' => 'Gedung Serbaguna Merpati, Jl. Merpati No.10, Jakarta'
            ],
            [
                'bride_name' => 'Savitri',
                'groom_name' => 'Anis',
                'bride_phone' => '081234567804',
                'groom_phone' => '081234567805',
                'akad_date' => Carbon::create(2025, 12, 29),
                'reception_date' => Carbon::create(2025, 12, 29),
                'event_location' => 'Balai Kartini, Jl. Gatot Subroto No.37, Jakarta'
            ],
            [
                'bride_name' => 'Coba',
                'groom_name' => 'Test',
                'bride_phone' => '081234567806',
                'groom_phone' => '081234567807',
                'akad_date' => Carbon::create(2026, 1, 3),
                'reception_date' => Carbon::create(2026, 1, 3),
                'event_location' => 'Balai Kartini, Jl. Gatot Subroto No.37, Jakarta'
            ],
            [
                'bride_name' => 'Suchi',
                'groom_name' => 'Budi',
                'bride_phone' => '081234567808',
                'groom_phone' => '081234567809',
                'akad_date' => Carbon::create(2026, 1, 9),
                'reception_date' => Carbon::create(2026, 1, 9),
                'event_location' => 'Gedung Serbaguna Merpati, Jl. Merpati No.10, Jakarta'
            ],
            [
                'bride_name' => 'Saripah',
                'groom_name' => 'Ahmad',
                'bride_phone' => '081234567810',
                'groom_phone' => '081234567811',
                'akad_date' => Carbon::create(2026, 1, 10),
                'reception_date' => Carbon::create(2026, 1, 10),
                'event_location' => 'Balai Kartini, Jl. Gatot Subroto No.37, Jakarta'
            ],
            [
                'bride_name' => 'Indriyani',
                'groom_name' => 'Budi',
                'bride_phone' => '081234567812',
                'groom_phone' => '081234567813',
                'akad_date' => Carbon::create(2026, 1, 16),
                'reception_date' => Carbon::create(2026, 1, 16),
                'event_location' => 'Gedung Serbaguna Merpati, Jl. Merpati No.10, Jakarta'
            ],
            [
                'bride_name' => 'Bina',
                'groom_name' => 'Ananda',
                'bride_phone' => '081234567814',
                'groom_phone' => '081234567815',
                'akad_date' => Carbon::create(2026, 1, 17),
                'reception_date' => Carbon::create(2026, 1, 17),
                'event_location' => 'Balai Kartini, Jl. Gatot Subroto No.37, Jakarta'
            ],
            [
                'bride_name' => 'Salsabilla',
                'groom_name' => 'Rahman',
                'bride_phone' => '081234567816',
                'groom_phone' => '081234567817',
                'akad_date' => Carbon::create(2026, 1, 11),
                'reception_date' => Carbon::create(2026, 1, 11),
                'event_location' => 'Gedung Serbaguna Merpati, Jl. Merpati No.10, Jakarta'
            ],
        ];

        foreach ($clients as $client) {
            Client::create($client);
        }
    }
}
