<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewContactRequestNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public array $data)
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
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->view('components.mail.notifications.notification', [
                        'locale' => app()->getLocale(),
                        'header' => __('mail.new_request_has_been_submitted'),
                        'name' => $this->data['owner'],
                        'content' => __('mail.new_request_has_been_submitted_body', ['name' => $this->data['by']]),
                        'action_btn' => [
                            'text' =>  __('mail.view_request_button'),
                            'url' => url('/timmy/contact-forms'),
                        ],
                    ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'data' => $this->data,
        ];
    }
}
