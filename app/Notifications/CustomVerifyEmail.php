<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\URL;

class CustomVerifyEmail extends Notification implements ShouldQueue
{
    use Queueable;

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
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject(Lang::get('Sahkan Alamat Emel Anda'))
            ->greeting('Salam Sejahtera, '.($notifiable->first_name ?? 'Pengguna'))
            ->line(Lang::get('Terima kasih kerana mendaftar dengan :app.', ['app' => config('app.name')]))
            ->line(Lang::get('Sila klik butang di bawah untuk mengesahkan alamat emel anda.'))
            ->action(Lang::get('Sahkan Emel'), $verificationUrl)
            ->line(Lang::get('Jika anda tidak mendaftar akaun ini, sila abaikan emel ini.'))
            ->salutation('Terima Kasih, '.config('app.name'));
    }

    /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(config('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }
}
