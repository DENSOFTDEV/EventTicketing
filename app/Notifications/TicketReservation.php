<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketReservation extends Notification
{
    use Queueable;

    private $user;
    private $tickets;
    private $event;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $tickets, $event)
    {
        $this->user = $user;
        $this->tickets = $tickets;
        $this->event = $event;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)->markdown('mail.ticket.reservation', [
            'user' => $this->user,
            'tickets' => $this->tickets,
            'event' => $this->event,
            'url' => route('tickets')
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
