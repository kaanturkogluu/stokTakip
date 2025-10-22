<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Site Information
            ['key' => 'site_name', 'value' => 'Macrotech', 'type' => 'string', 'group' => 'site', 'description' => 'Site adı'],
            ['key' => 'site_description', 'value' => 'Telefon satış ve servis hizmetleri', 'type' => 'text', 'group' => 'site', 'description' => 'Site açıklaması'],
            ['key' => 'site_logo', 'value' => '/images/logo.svg', 'type' => 'string', 'group' => 'site', 'description' => 'Site logosu'],
            ['key' => 'site_favicon', 'value' => '/images/favicon.svg', 'type' => 'string', 'group' => 'site', 'description' => 'Site favicon'],
            
            // Contact Information
            ['key' => 'contact_email', 'value' => 'info@macrotech.com', 'type' => 'string', 'group' => 'contact', 'description' => 'İletişim e-postası'],
            ['key' => 'contact_phone', 'value' => '+90 212 555 0123', 'type' => 'string', 'group' => 'contact', 'description' => 'Ana telefon numarası'],
            ['key' => 'contact_address', 'value' => 'Maslak Mahallesi, Büyükdere Caddesi No: 123, Sarıyer/İstanbul', 'type' => 'text', 'group' => 'contact', 'description' => 'Adres'],
            ['key' => 'whatsapp_number', 'value' => '+90 555 123 45 67', 'type' => 'string', 'group' => 'contact', 'description' => 'WhatsApp numarası'],
            ['key' => 'sales_phone', 'value' => '+90 555 123 45 69', 'type' => 'string', 'group' => 'contact', 'description' => 'Satış telefonu'],
            ['key' => 'technical_phone', 'value' => '+90 555 123 45 68', 'type' => 'string', 'group' => 'contact', 'description' => 'Teknik destek telefonu'],
            ['key' => 'main_phone', 'value' => '+90 555 123 45 67', 'type' => 'string', 'group' => 'contact', 'description' => 'Ana telefon'],
            
            // Working Hours
            ['key' => 'working_hours_weekdays', 'value' => '09:00 - 18:00', 'type' => 'string', 'group' => 'working_hours', 'description' => 'Hafta içi çalışma saatleri'],
            ['key' => 'working_hours_saturday', 'value' => '10:00 - 16:00', 'type' => 'string', 'group' => 'working_hours', 'description' => 'Cumartesi çalışma saatleri'],
            ['key' => 'working_hours_sunday', 'value' => 'Kapalı', 'type' => 'string', 'group' => 'working_hours', 'description' => 'Pazar çalışma saatleri'],
            ['key' => 'whatsapp_support', 'value' => '7/24', 'type' => 'string', 'group' => 'working_hours', 'description' => 'WhatsApp destek saatleri'],
            
            // Social Media
            ['key' => 'facebook_url', 'value' => '', 'type' => 'string', 'group' => 'social', 'description' => 'Facebook URL'],
            ['key' => 'instagram_url', 'value' => '', 'type' => 'string', 'group' => 'social', 'description' => 'Instagram URL'],
            ['key' => 'twitter_url', 'value' => '', 'type' => 'string', 'group' => 'social', 'description' => 'Twitter URL'],
            ['key' => 'youtube_url', 'value' => '', 'type' => 'string', 'group' => 'social', 'description' => 'YouTube URL'],
            
            // Google Maps Location
            ['key' => 'google_maps_latitude', 'value' => '41.1033', 'type' => 'string', 'group' => 'location', 'description' => 'Google Maps enlem (latitude)'],
            ['key' => 'google_maps_longitude', 'value' => '29.0108', 'type' => 'string', 'group' => 'location', 'description' => 'Google Maps boylam (longitude)'],
            ['key' => 'google_maps_zoom', 'value' => '15', 'type' => 'string', 'group' => 'location', 'description' => 'Google Maps zoom seviyesi'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}