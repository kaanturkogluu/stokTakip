<?php

namespace Database\Seeders;

use App\Models\Phone;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PhoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $phones = [
            [
                'name' => 'iPhone 15 Pro Max',
                'description' => 'Apple\'ın en yeni ve en güçlü iPhone modeli. A17 Pro çip, 48MP ana kamera ve Titanium tasarım.',
                'price' => 89999.00,
                'brand' => 'Apple',
                'model' => 'iPhone 15 Pro Max',
                'color' => 'Natural Titanium',
                'storage' => '256GB',
                'ram' => '8GB',
                'screen_size' => '6.7 inç',
                'camera' => '48MP + 12MP + 12MP',
                'battery' => '4422 mAh',
                'os' => 'iOS 17',
                'images' => ['/images/default-phone.svg'],
                'whatsapp_number' => '905551234567',
                'is_featured' => true,
            ],
            [
                'name' => 'Samsung Galaxy S24 Ultra',
                'description' => 'Samsung\'un flagship modeli. S Pen desteği, 200MP kamera ve AI özellikleri.',
                'price' => 79999.00,
                'brand' => 'Samsung',
                'model' => 'Galaxy S24 Ultra',
                'color' => 'Titanium Black',
                'storage' => '512GB',
                'ram' => '12GB',
                'screen_size' => '6.8 inç',
                'camera' => '200MP + 50MP + 10MP + 10MP',
                'battery' => '5000 mAh',
                'os' => 'Android 14',
                'images' => ['/images/default-phone.svg'],
                'whatsapp_number' => '905551234567',
                'is_featured' => true,
            ],
            [
                'name' => 'iPhone 14',
                'description' => 'Güvenilir performans ve harika kamera kalitesi. A15 Bionic çip ile güçlendirilmiş.',
                'price' => 45999.00,
                'brand' => 'Apple',
                'model' => 'iPhone 14',
                'color' => 'Blue',
                'storage' => '128GB',
                'ram' => '6GB',
                'screen_size' => '6.1 inç',
                'camera' => '12MP + 12MP',
                'battery' => '3279 mAh',
                'os' => 'iOS 16',
                'images' => ['/images/default-phone.svg'],
                'whatsapp_number' => '905551234567',
                'is_featured' => true,
            ],
            [
                'name' => 'Samsung Galaxy A54',
                'description' => 'Orta segmentte mükemmel performans. 50MP kamera ve uzun batarya ömrü.',
                'price' => 18999.00,
                'brand' => 'Samsung',
                'model' => 'Galaxy A54',
                'color' => 'Awesome Violet',
                'storage' => '128GB',
                'ram' => '8GB',
                'screen_size' => '6.4 inç',
                'camera' => '50MP + 12MP + 5MP',
                'battery' => '5000 mAh',
                'os' => 'Android 13',
                'images' => ['/images/default-phone.svg'],
                'whatsapp_number' => '905551234567',
                'is_featured' => true,
            ],
            [
                'name' => 'Xiaomi Redmi Note 12 Pro',
                'description' => 'Uygun fiyatlı güçlü performans. 108MP kamera ve hızlı şarj.',
                'price' => 12999.00,
                'brand' => 'Xiaomi',
                'model' => 'Redmi Note 12 Pro',
                'color' => 'Polar White',
                'storage' => '128GB',
                'ram' => '8GB',
                'screen_size' => '6.67 inç',
                'camera' => '108MP + 8MP + 2MP',
                'battery' => '5000 mAh',
                'os' => 'Android 12',
                'images' => ['/images/default-phone.svg'],
                'whatsapp_number' => '905551234567',
                'is_featured' => true,
            ],
            [
                'name' => 'OnePlus 11',
                'description' => 'Hızlı performans ve premium tasarım. Snapdragon 8 Gen 2 çip.',
                'price' => 34999.00,
                'brand' => 'OnePlus',
                'model' => 'OnePlus 11',
                'color' => 'Eternal Green',
                'storage' => '256GB',
                'ram' => '16GB',
                'screen_size' => '6.7 inç',
                'camera' => '50MP + 32MP + 48MP',
                'battery' => '5000 mAh',
                'os' => 'Android 13',
                'images' => ['/images/default-phone.svg'],
                'whatsapp_number' => '905551234567',
                'is_featured' => true,
            ],
        ];

        foreach ($phones as $phoneData) {
            Phone::create($phoneData);
        }
    }
}
