<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class RegistrationSuccess extends Notification implements ShouldQueue
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
        return (new MailMessage)
            ->subject(Lang::get('Pendaftaran Berjaya! Selamat Datang ke ' . config('app.name')))
            ->greeting('Selamat Datang, ' . ($notifiable->first_name ?? 'Pengguna') . '!')
            ->line(Lang::get('Akaun anda telah berjaya didaftarkan dalam sistem kami.'))
            ->line(Lang::get('Kini anda boleh mula menggunakan platform ini untuk mengurus maklumat akademik dan kehadiran anda.'))
            ->action(Lang::get('Log Masuk ke Dashboard'), url('/dashboard'))
            ->line(Lang::get('Terima kasih kerana menyertai kami!'))
            ->salutation('Salam Hormat, ' . config('app.name'));
    }
}
