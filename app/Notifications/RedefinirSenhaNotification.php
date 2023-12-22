<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;


class RedefinirSenhaNotification extends Notification
{
    use Queueable;
    public $token;
    public $email;
    public $nome;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token, $email, $name)
    {
        $this->token = $token;
        $this->email = $email;
        $this->name = $name;
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
         $url = 'http://localhost:8000/password/reset/'.$this->token.'?email='.$this->email;
         $minutos =  config('auth.passwords.'.config('auth.defaults.passwords').'.expire');
        return (new MailMessage)
            ->subject(('Atualização de senha'))
            ->greeting('Olà '.$this->name)
            ->line(Lang::getFromJson('Você recebe esse e-mail porque recebemos uma solicitação que você esqueceu a sua senha.'))
            ->action(Lang::getFromJson('Click aqui para recuperar a senha'), $url)//($url, ['token' => , 'email' => $notifiable->getEmailForPasswordReset()], false))
            ->line(Lang::getFromJson('O link acima expire em: '.$minutos.' minutos.'))
            ->line(Lang::getFromJson('Caso você não tenha requisitado a alteração de senha,não precisa fazer nenhum ação'))
            ->salutation('Até breve');
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
