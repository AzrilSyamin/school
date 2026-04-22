<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class CustomResetPassword extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
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
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject(Lang::get('Notifikasi Tetapan Semula Kata Laluan'))
            ->greeting('Salam Sejahtera, ' . ($notifiable->first_name ?? 'Pengguna'))
            ->line(Lang::get('Anda menerima emel ini kerana kami menerima permintaan tetapan semula kata laluan untuk akaun anda.'))
            ->action(Lang::get('Tetapan Semula Kata Laluan'), $url)
            ->line(Lang::get('Pautan tetapan semula kata laluan ini akan tamat tempoh dalam :count minit.', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
            ->line(Lang::get('Jika anda tidak meminta tetapan semula kata laluan, tiada tindakan lanjut diperlukan.'))
            ->salutation('Terima Kasih, ' . config('app.name'));
    }
}
