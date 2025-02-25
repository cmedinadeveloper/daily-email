<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\DailyEmail;

class SendDailyEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-daily-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily emails to users at 5 PM in their local timezone';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $timezone = $this->argument('timezone');

        $users = User::where('timezone', $timezone)->get();

        foreach ($users as $user) {
            Mail::to($user->email)->send(new DailyEmail($user));
            $this->info("Sent email to {$user->email} in timezone {$timezone}");
        }
    }
}
