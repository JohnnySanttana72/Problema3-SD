<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class ContatoEmail extends Notification
{
    use Queueable;
    private $data;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
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
        return (new MailMessage)
                    ->subject('Mensagem do Sistema de Monitoramento')
                    ->line('Ocorreu um acidente com o usuário:')
                    ->line(new HtmlString('<p style="box-sizing: border-box; position: relative; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: center;">Dados do Acidente:</p>'))
                    ->line(new HtmlString('<p style="box-sizing: border-box; position: relative; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: center;"><strong style=" padding:2px 8px 2px 8px; font-size:20px; color: #282c28;">'.$this->data->dado.'</strong></p>'))
                    ->salutation('Até mais!')
                    ->markdown('vendor.notifications.email');
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
