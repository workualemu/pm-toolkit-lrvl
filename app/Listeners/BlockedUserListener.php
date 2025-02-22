<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Validated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class BlockedUserListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Validated $event): void
    {
        $user = $event->user; // User object is available in the Validated event

        if ($user->is_suspended) {
            Auth::logout();

            Session::flash('error', 'Your account is blocked. Please contact support.');

            abort(redirect()->route('login'));
        }
    }
}
