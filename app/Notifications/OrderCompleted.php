<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Barryvdh\DomPDF\Facade\pdf;
use App\Models\Order;

class OrderCompleted extends Notification
{
    use Queueable;

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
        $pdf = PDF::loadView('emails.invoice', ['order' => $this->order]);

        return (new MailMessage)
                    ->subject('Votre commande est terminée')
                    ->line('Votre commande a été complétée')
                    ->line('Merci de payer votre commande!');
    }

    public function toArray($notifiable)
    {
        return [
            'order_id' => $this->order->id,
        ];
    }
}
