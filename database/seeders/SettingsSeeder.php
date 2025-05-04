<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run()
    {
        Settings::set('gst_rate', 0.10);
        Settings::set('invoice.prefix', 'INV-');
        Settings::set('invoice.next_number', 1001);
        Settings::set('invoice.default_template', 'custom');
    }
}