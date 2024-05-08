<?php

namespace App\Providers;

use App\Events\ChirpCreated;
use App\Events\CommentCreated;
use App\Service\AnotherTestService;
use App\Service\TestService;
use App\Interfaces\TestInterface;
use App\Listeners\SendChirpCreatedNotifications;
use App\Listeners\SendCommentCreatedNotification;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(CommentCreated::class, SendCommentCreatedNotification::class);
        // Event::listen(ChirpCreated::class, SendChirpCreatedNotifications::class);
    }
}
