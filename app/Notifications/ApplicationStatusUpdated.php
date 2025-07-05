<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicationStatusUpdated extends Notification
{
    use Queueable;

    protected $job;
    protected $status;
    protected $interviewDate;
    /**
     * Create a new notification instance.
     */
    public function __construct($job, $status, $interviewDate = null)
    {
        $this->job = $job;
        $this->status = $status;
        $this->interviewDate = $interviewDate;
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
        $message = "📢 Status lamaran Anda untuk posisi {$this->job->nama_lowongan} telah diubah menjadi: {$this->status}.";
        if ($this->status === 'interview' && $this->interviewDate) {
            $message .= ' Jadwal interview: ' . date('d M Y H:i', strtotime($this->interviewDate));
        }

        return [
            'title' => 'Status Lamaran Diperbarui',
            'message' => $message,
            'job_id' => $this->job->id,
            'status' => $this->status,
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
