<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add Google Maps location fields to settings table
        DB::table('settings')->insert([
            [
                'key' => 'google_maps_latitude',
                'value' => '41.1033',
                'type' => 'string',
                'group' => 'location',
                'description' => 'Google Maps enlem (latitude)',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'google_maps_longitude',
                'value' => '29.0108',
                'type' => 'string',
                'group' => 'location',
                'description' => 'Google Maps boylam (longitude)',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'google_maps_zoom',
                'value' => '15',
                'type' => 'string',
                'group' => 'location',
                'description' => 'Google Maps zoom seviyesi',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'google_maps_api_key',
                'value' => '',
                'type' => 'string',
                'group' => 'location',
                'description' => 'Google Maps API anahtarı (opsiyonel)',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('settings')->whereIn('key', [
            'google_maps_latitude',
            'google_maps_longitude', 
            'google_maps_zoom',
            'google_maps_api_key'
        ])->delete();
    }
};