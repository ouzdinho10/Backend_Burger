<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCanceled extends Notification
{
    protected $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Votre commande a été annulée')
                    ->greeting('Bonjour ' . $notifiable->nom)
                    ->line('Votre commande pour le burger ' . $this->order->burger->nom . ' a été annulée.')
                    ->line('Merci de votre compréhension!');
    }
}
