<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::updateOrCreate(
            ['id' => 1],
            [
                'company_name' => 'ReconX',
                'tax_id' => '123-456-789',
                'country' => 'United States',
                'base_currency' => 'USD - US Dollar',
                'address' => '123 Business Center, City',
                'logo_path' => 'uploads/settings/logo.png',
                'invoice_notes' => 'Thank you for your business. Please contact info@reconx.com for any queries.',
                'tax_percentage' => 8.25,
                'stripe_public_key' => 'pk_test_demo123456',
                'stripe_secret_key' => 'sk_test_demo123456',
                'webhook_url' => 'https://reconx.test/webhook',
                'webhook_secret' => 'whsec_demo123456',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
