<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;
use App\Models\Timezone;
use App\Models\User;
use App\Mail\DailyEmail;
use Illuminate\Support\Facades\Mail;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Artisan::command('schedule:daily-emails', function (Schedule $schedule) {
    $timezones = Timezone::pluck('name');

    $this->info('Timezones: ' . $timezones->implode(', '));

    if ($timezones->isEmpty()) {
        $this->error('No timezones found in the database.');
        return;
    }

    foreach ($timezones as $timezone) {
        $schedule->call(function () use ($timezone) {
            $users = User::where('timezone', $timezone)->get();

            if ($users->isEmpty()) {
                $this->warn("No users found in the $timezone timezone.");
                return;
            }

            foreach ($users as $user) {
                Mail::to($user->email)->send(new DailyEmail($user));
            }
        })
            ->timezone($timezone)
            ->at('17:00');
    }
})->purpose('Schedule daily emails at 5 PM for each timezone');
