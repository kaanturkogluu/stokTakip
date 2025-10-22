<?php

namespace Database\Seeders;

use App\Models\Screen;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScreenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $screens = [
            // Küçük Ekranlar (1-5.5 inç)
            [
                'name' => '4.7 inç',
                'size_inches' => 4.7,
                'resolution' => '750x1334',
                'is_active' => true,
            ],
            [
                'name' => '5.0 inç',
                'size_inches' => 5.0,
                'resolution' => '1080x1920',
                'is_active' => true,
            ],
            [
                'name' => '5.2 inç',
                'size_inches' => 5.2,
                'resolution' => '1080x1920',
                'is_active' => true,
            ],
            [
                'name' => '5.4 inç',
                'size_inches' => 5.4,
                'resolution' => '1080x2340',
                'is_active' => true,
            ],
            [
                'name' => '5.5 inç',
                'size_inches' => 5.5,
                'resolution' => '1080x1920',
                'is_active' => true,
            ],

            // Orta Ekranlar (5.6-6.5 inç)
            [
                'name' => '6.0 inç',
                'size_inches' => 6.0,
                'resolution' => '1080x2340',
                'is_active' => true,
            ],
            [
                'name' => '6.1 inç',
                'size_inches' => 6.1,
                'resolution' => '1170x2532',
                'is_active' => true,
            ],
            [
                'name' => '6.2 inç',
                'size_inches' => 6.2,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '6.3 inç',
                'size_inches' => 6.3,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '6.4 inç',
                'size_inches' => 6.4,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '6.5 inç',
                'size_inches' => 6.5,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],

            // Büyük Ekranlar (6.6-7.5 inç)
            [
                'name' => '6.6 inç',
                'size_inches' => 6.6,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '6.67 inç',
                'size_inches' => 6.67,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '6.7 inç',
                'size_inches' => 6.7,
                'resolution' => '1290x2796',
                'is_active' => true,
            ],
            [
                'name' => '6.8 inç',
                'size_inches' => 6.8,
                'resolution' => '1440x3088',
                'is_active' => true,
            ],
            [
                'name' => '6.9 inç',
                'size_inches' => 6.9,
                'resolution' => '1440x3200',
                'is_active' => true,
            ],
            [
                'name' => '7.0 inç',
                'size_inches' => 7.0,
                'resolution' => '1440x3200',
                'is_active' => true,
            ],
            [
                'name' => '7.2 inç',
                'size_inches' => 7.2,
                'resolution' => '1440x3200',
                'is_active' => true,
            ],
            [
                'name' => '7.3 inç',
                'size_inches' => 7.3,
                'resolution' => '1440x3200',
                'is_active' => true,
            ],
            [
                'name' => '7.4 inç',
                'size_inches' => 7.4,
                'resolution' => '1440x3200',
                'is_active' => true,
            ],
            [
                'name' => '7.5 inç',
                'size_inches' => 7.5,
                'resolution' => '1440x3200',
                'is_active' => true,
            ],

            // Çok Büyük Ekranlar (7.6+ inç)
            [
                'name' => '8.0 inç',
                'size_inches' => 8.0,
                'resolution' => '1600x2560',
                'is_active' => true,
            ],
            [
                'name' => '8.3 inç',
                'size_inches' => 8.3,
                'resolution' => '1668x2388',
                'is_active' => true,
            ],
            [
                'name' => '8.9 inç',
                'size_inches' => 8.9,
                'resolution' => '1600x2560',
                'is_active' => true,
            ],
            [
                'name' => '9.7 inç',
                'size_inches' => 9.7,
                'resolution' => '1536x2048',
                'is_active' => true,
            ],
            [
                'name' => '10.2 inç',
                'size_inches' => 10.2,
                'resolution' => '1620x2160',
                'is_active' => true,
            ],
            [
                'name' => '10.9 inç',
                'size_inches' => 10.9,
                'resolution' => '1640x2360',
                'is_active' => true,
            ],
            [
                'name' => '11.0 inç',
                'size_inches' => 11.0,
                'resolution' => '1668x2388',
                'is_active' => true,
            ],
            [
                'name' => '12.9 inç',
                'size_inches' => 12.9,
                'resolution' => '2048x2732',
                'is_active' => true,
            ],

            // Özel Ekranlar
            [
                'name' => '6.06 inç',
                'size_inches' => 6.06,
                'resolution' => '1170x2532',
                'is_active' => true,
            ],
            [
                'name' => '6.12 inç',
                'size_inches' => 6.12,
                'resolution' => '1080x2340',
                'is_active' => true,
            ],
            [
                'name' => '6.26 inç',
                'size_inches' => 6.26,
                'resolution' => '1080x2340',
                'is_active' => true,
            ],
            [
                'name' => '6.28 inç',
                'size_inches' => 6.28,
                'resolution' => '1080x2340',
                'is_active' => true,
            ],
            [
                'name' => '6.39 inç',
                'size_inches' => 6.39,
                'resolution' => '1080x2340',
                'is_active' => true,
            ],
            [
                'name' => '6.43 inç',
                'size_inches' => 6.43,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '6.44 inç',
                'size_inches' => 6.44,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '6.55 inç',
                'size_inches' => 6.55,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '6.58 inç',
                'size_inches' => 6.58,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '6.62 inç',
                'size_inches' => 6.62,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '6.63 inç',
                'size_inches' => 6.63,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '6.64 inç',
                'size_inches' => 6.64,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '6.65 inç',
                'size_inches' => 6.65,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '6.66 inç',
                'size_inches' => 6.66,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '6.68 inç',
                'size_inches' => 6.68,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '6.69 inç',
                'size_inches' => 6.69,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '6.71 inç',
                'size_inches' => 6.71,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '6.72 inç',
                'size_inches' => 6.72,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '6.73 inç',
                'size_inches' => 6.73,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '6.74 inç',
                'size_inches' => 6.74,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '6.76 inç',
                'size_inches' => 6.76,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '6.78 inç',
                'size_inches' => 6.78,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '6.79 inç',
                'size_inches' => 6.79,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '6.81 inç',
                'size_inches' => 6.81,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '6.82 inç',
                'size_inches' => 6.82,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '6.83 inç',
                'size_inches' => 6.83,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '6.84 inç',
                'size_inches' => 6.84,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '6.85 inç',
                'size_inches' => 6.85,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '6.86 inç',
                'size_inches' => 6.86,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '6.87 inç',
                'size_inches' => 6.87,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '6.88 inç',
                'size_inches' => 6.88,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '6.89 inç',
                'size_inches' => 6.89,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '6.92 inç',
                'size_inches' => 6.92,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '6.93 inç',
                'size_inches' => 6.93,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '6.94 inç',
                'size_inches' => 6.94,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '6.95 inç',
                'size_inches' => 6.95,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '6.96 inç',
                'size_inches' => 6.96,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '6.97 inç',
                'size_inches' => 6.97,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '6.98 inç',
                'size_inches' => 6.98,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '6.99 inç',
                'size_inches' => 6.99,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '7.01 inç',
                'size_inches' => 7.01,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '7.02 inç',
                'size_inches' => 7.02,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '7.03 inç',
                'size_inches' => 7.03,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '7.04 inç',
                'size_inches' => 7.04,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '7.05 inç',
                'size_inches' => 7.05,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '7.06 inç',
                'size_inches' => 7.06,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '7.07 inç',
                'size_inches' => 7.07,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '7.08 inç',
                'size_inches' => 7.08,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '7.09 inç',
                'size_inches' => 7.09,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '7.11 inç',
                'size_inches' => 7.11,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '7.12 inç',
                'size_inches' => 7.12,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '7.13 inç',
                'size_inches' => 7.13,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '7.14 inç',
                'size_inches' => 7.14,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '7.15 inç',
                'size_inches' => 7.15,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '7.16 inç',
                'size_inches' => 7.16,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '7.17 inç',
                'size_inches' => 7.17,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '7.18 inç',
                'size_inches' => 7.18,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '7.19 inç',
                'size_inches' => 7.19,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '7.21 inç',
                'size_inches' => 7.21,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '7.22 inç',
                'size_inches' => 7.22,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '7.23 inç',
                'size_inches' => 7.23,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '7.24 inç',
                'size_inches' => 7.24,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '7.25 inç',
                'size_inches' => 7.25,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '7.26 inç',
                'size_inches' => 7.26,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '7.27 inç',
                'size_inches' => 7.27,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '7.28 inç',
                'size_inches' => 7.28,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '7.29 inç',
                'size_inches' => 7.29,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '7.31 inç',
                'size_inches' => 7.31,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '7.32 inç',
                'size_inches' => 7.32,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '7.33 inç',
                'size_inches' => 7.33,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '7.34 inç',
                'size_inches' => 7.34,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '7.35 inç',
                'size_inches' => 7.35,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '7.36 inç',
                'size_inches' => 7.36,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '7.37 inç',
                'size_inches' => 7.37,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '7.38 inç',
                'size_inches' => 7.38,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '7.39 inç',
                'size_inches' => 7.39,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '7.41 inç',
                'size_inches' => 7.41,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '7.42 inç',
                'size_inches' => 7.42,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '7.43 inç',
                'size_inches' => 7.43,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '7.44 inç',
                'size_inches' => 7.44,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '7.45 inç',
                'size_inches' => 7.45,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '7.46 inç',
                'size_inches' => 7.46,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '7.47 inç',
                'size_inches' => 7.47,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '7.48 inç',
                'size_inches' => 7.48,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
            [
                'name' => '7.49 inç',
                'size_inches' => 7.49,
                'resolution' => '1080x2400',
                'is_active' => true,
            ],
        ];

        foreach ($screens as $screenData) {
            // Eğer bu ekran boyutu zaten varsa atla
            if (!Screen::where('name', $screenData['name'])->exists()) {
                Screen::create($screenData);
            }
        }
    }
}
