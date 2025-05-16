<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactRequestSubmitted extends Notification
{
    use Queueable;
    public string $lang;

    /**
     * Create a new notification instance.
     */
    public function __construct($locale)
    {
        $this->lang = $locale;
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
        return $this->lang == 'fa'
            ? (new MailMessage)
                    ->subject('درخواست تماس شما ثبت شد')
                    ->line('سلام دوست من!')
                    ->line('درخواست تماس شما با من ثبت شد، در ۲۴ ساعت آینده با شما تماس خواهم گرفت.')
            : (new MailMessage)
                    ->subject('Your contact request has been submitted')
                    ->line('Hey there friend!')
                    ->line('I\'ve got your contact request and will call you within 24 hours.');
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
