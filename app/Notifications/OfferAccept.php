<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class OfferAccept extends Notification
{
    use Queueable;

    protected $delivery;

    public function __construct($delivery)
    {
        $this->delivery = $delivery;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your Offer Has Been Accepted!')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Good news! Your offer for the delivery has been accepted.')
            ->line('Pickup Address ID: ' . $this->delivery->takeOf_Address_id)
            ->line('Drop-off Address ID: ' . $this->delivery->dropOf_Address_id)
            ->line('Scheduled At: ' . $this->delivery->scheduled_at)
            ->line('Amount: ' . $this->delivery->cost . ' ' . $this->delivery->currency)
            ->action('View Delivery Details', url('/driver/deliveries/' . $this->delivery->id))
            ->line('Thank you for using our delivery service!');
    }
}