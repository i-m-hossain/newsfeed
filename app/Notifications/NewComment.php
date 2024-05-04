<?php

namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Slack\BlockKit\Blocks\SectionBlock;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Support\Str;


class NewComment extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Comment $comment)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // default mail
        // return ['mail'];
        // we want to send via slack
        return ['slack'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->action('Notification Action', url('/'))
            ->subject("New Comment from {$this->comment->user->name}")
            ->greeting("New Comment from {$this->comment->user->name}")
            ->line(Str::limit($this->comment->body, 50))
            ->action('Go to Newsfeed', url('/'));
    }

    /**
     * Get the Slack representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return SlackMessage
     */
    public function toSlack(object $notifiable): SlackMessage
    {
        return (new SlackMessage)
            ->success("A comment has been created!")
            ->from('NewsFeed')
            ->to('#laravel-notifications') // channel name
            ->content(Str::limit($this->comment->body)); // message
        // $slackMessage = (new SlackMessage)
        //     ->text("New comment from {$this->comment->user->name}")
        //     ->headerBlock("New comment from {$this->comment->user->name}")
        //     ->sectionBlock(function (SectionBlock $block) {
        //         $block->text("A new comment");
        //         $block->field(Str::limit($this->comment->body, 50));
        //     })
        //     ->dividerBlock()
        //     ->sectionBlock(function (SectionBlock $block) {
        //         $block->text("visit newsfeed!");
        //     });
        // return $slackMessage;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
