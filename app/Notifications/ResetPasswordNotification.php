<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    /**
     * @var mixed|string
     */
    private $url, $email, $first_name;

    /**
     * Create a new notification instance.
     *
     * @param string $url
     * @param string $email
     * @param string $first_name
     */
    public function __construct(string $url, $email, $first_name)
    {
        $this->url = $url;
        $this->email = $email;
        $this->first_name = $first_name;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url($this->url);
        $email = $this->email;
        $first_name = $this->first_name;
        return (new MailMessage())->view('vendor.notifications.reset_password.layout', compact('url', 'email', 'first_name'));
        /*return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url($this->url))
                    ->line('Thank you for using our application!');*/
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
