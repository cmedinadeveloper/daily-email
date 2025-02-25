<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Timezone;

class TimezoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timezones = User::distinct()->pluck('timezone');

        foreach ($timezones as $timezone) {
            Timezone::create(['name' => $timezone]);
        }
    }
}
