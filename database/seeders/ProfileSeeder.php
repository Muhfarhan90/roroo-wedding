<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Profile;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Profile::updateOrCreate(
            ['id' => 1],
            [
                'business_name' => 'ROROO Wedding Make Up',
                'owner_name' => 'Admin ROROO',
                'email' => 'Miminroro1@gmail.com',
                'phone' => '08970001235',
                'address' => 'Perumahan Kaliwulu blok AC no.1
Kec.Plered Kab Cirebon
(Depan Lapangan)',
                'banks' => [
                    [
                        'bank_name' => 'Bank BCA',
                        'account_number' => '774-559-3402',
                        'account_holder' => 'FATIMATUZ ZAHRO',
                    ],
                    [
                        'bank_name' => 'BRI',
                        'account_number' => '0601-01000-547-563',
                        'account_holder' => 'FATIMATUZ ZAHRO',
                    ],
                ],
                'social_media' => [
                    [
                        'platform' => 'Instagram',
                        'value' => 'https://www.instagram.com/roroo_makeupartist/',
                    ],
                    [
                        'platform' => 'WhatsApp',
                        'value' => 'https://wa.me/628970001235',
                    ],
                    [
                        'platform' => 'TikTok',
                        'value' => '@roroowedding',
                    ],
                    [
                        'platform' => 'Website',
                        'value' => 'https://roroowedding.com',
                    ],
                ],
                'description' => 'ROROO Wedding Make Up adalah penyedia jasa make up profesional untuk pernikahan dan acara spesial Anda. Kami berkomitmen memberikan layanan terbaik dengan hasil yang memukau.',
            ]
        );
    }
}
