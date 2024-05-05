<?php

namespace App\Listeners;

use App\Events\ChirpCreated;
use App\Models\User;
use App\Notifications\NewChirp;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendChirpCreatedNotifications implements ShouldQueue
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
    public function handle(ChirpCreated $event): void
    {
        //sending mail to all the users except the user creating the chirp
        try {
            //code...
            foreach (User::whereNot('id', $event->chirp->user_id)->limit(5)->cursor() as $user) {
                $user->notify( new NewChirp($event->chirp));
            }
        } catch (\Exception $ex) {
            Log::error("Chirp create notification errror:". $ex->getMessage());
        }

    }
}
