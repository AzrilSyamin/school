<?php

namespace App\Services;

use App\Jobs\SendEmailJob;
use Illuminate\Support\Facades\Mail;

class EmailService
{
    /**
     * Send an email using a specified mailable class.
     *
     * @param string $to
     * @param mixed $mailable
     * @param bool $useQueue
     * @return void
     */
    public function send(string $to, $mailable, bool $useQueue = true): void
    {
        if ($useQueue) {
            Mail::to($to)->queue($mailable);
        } else {
            Mail::to($to)->send($mailable);
        }
    }

    /**
     * Send a basic notification email (helper method).
     *
     * @param string $to
     * @param string $subject
     * @param string $view
     * @param array $data
     * @return void
     */
    public function sendNotification(string $to, string $subject, string $view, array $data = []): void
    {
        // This is a generic way to send emails if we don't want to create separate Mailable classes for everything
        // But for this project, we'll mostly use Mailable classes for better structure.
    }
}
