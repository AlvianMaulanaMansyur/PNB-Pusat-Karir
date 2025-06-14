<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;


class JobApplicationSubmitted extends Notification
{
    use Queueable;
    protected $job;
    protected $employee;
    /**
     * Create a new notification instance.
     */
    public function __construct($job, $employee)
    {
        $this->job = $job;
        $this->employee = $employee;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())->line('The introduction to the notification.')->action('Notification Action', url('/'))->line('Thank you for using our application!');
    }

    public function toDatabase($notifiable)
    {
        // Log::info('Job data:', ['job' => $this->job->toArray()]);
        return [
            'title' => 'Lamaran berhasil dikirim!',
            'message' => 'Anda telah melamar untuk posisi: ' . $this->job->nama_lowongan,
            'job_id' => $this->job->id,
        ];
    }
    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
                //
            ];
    }
}
