<?php

namespace App\Listeners;

use App\Events\CommentCreated;
use App\Models\Comment;
use App\Models\User;
use App\Notifications\NewComment;
use App\Notifications\NewCommentSlackNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendCommentCreatedNotification implements ShouldQueue
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
    public function handle(CommentCreated $event): void
    {
        /**
         * sending emails to other commented users for the same post
         *
         * Select * from newsfeed.users where id in (SELECT user_id FROM newsfeed.comments where chirp_id=chirp_id and user_id <> commented_user_id);
         **/
        $usersCommented = Comment::where('chirp_id', $event->comment->chirp_id)
            ->where('user_id', '!=', $event->comment->user_id)
            ->pluck('user_id');
        $users = User::whereIn('id', $usersCommented)->limit(5)->get();
        /**
         * using User model's notifiable trait which provides notify method
         */
        // foreach ($users->cursor() as $user) {
        //     $user->notify(new NewComment($event->comment));
        // }

        /**
         * using Notification facade to send mail
         * */

        //!Todo:-- sending email (need to upgrade the plan, limit exceeded or change the account)
        // Notification::send($users, new NewComment($event->comment));

        //sending to slack channel
        Notification::route('slack', config('notification.SLACK_BOT_USER_DEFAULT_CHANNEL'))
        ->notify(new NewCommentSlackNotification($event->comment));
    }
}
