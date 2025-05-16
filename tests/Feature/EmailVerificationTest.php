<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    public function it_dispatches_verified_event_after_email_verification(): void
    {
        Event::fake();

        $user = User::factory()->unverified()->create();

        $user->markEmailAsVerified();

        // Assert the Verified event was dispatched
        Event::assertDispatched(Verified::class, function ($event) use ($user) {
            return $event->user->is($user);
        });
    }
}
