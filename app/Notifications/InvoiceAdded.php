<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\invoices;
class InvoiceAdded extends Notification
{
    use Queueable;
    private $invoiceId;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($invoiceId)
    {
        $this->invoiceId = $invoiceId;
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

        $url = 'http://127.0.0.1:8000/InvoicesDetails/'.$this->invoiceId;

        return (new MailMessage)
                    ->subject('اضافة فاتورة جديدة')
                    ->line('اضافة فاتورة جديدة')
                    ->action('عرض الفاتورة', $url)
                    ->line('شكرا لاستخدامك مورا سوفت لادارة الفواتير');
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
