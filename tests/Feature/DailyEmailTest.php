<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\DailyEmail;

class DailyEmailTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_daily_emails_are_sent_at_5pm(): void
    {
        $timezone = 'America/New_York';
        $user = User::factory()->create(['timezone' => $timezone]);

        Carbon::setTestNow((Carbon::today()->setTimezone($timezone)->setTime(17, 0)));

        Mail::fake();

        $this->simulateDailyEmailTask($timezone);

        Mail::assertSent(DailyEmail::class, function ($mail) use ($user) {
            return $mail->user->id === $user->id;
        });

        Carbon::setTestNow();
    }

    protected function simulateDailyEmailTask(string $timezone): void
    {
        // Get users in the specified timezone
        $users = User::where('timezone', $timezone)->get();

        // Send emails to users in the specified timezone
        foreach ($users as $user) {
            Mail::to($user->email)->send(new DailyEmail($user));
        }
    }
}
