<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Product;

class ProductApprovedNotification extends Notification
{
    use Queueable;

    protected $product;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
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
            ->subject('Your Product Has Been Approved - Transamota')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Great news! Your product "' . $this->product->name . '" has been approved by our admin team.')
            ->line('Your product is now live and visible to all buyers on Transamota.')
            ->action('View Your Product', url('/products/' . $this->product->id))
            ->line('Thank you for using Transamota!')
            ->salutation("Best regards,\n\nThe Transamota Team");
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
            'product_id' => $this->product->id,
            'product_name' => $this->product->name,
            'message' => 'Your product "' . $this->product->name . '" has been approved.'
        ];
    }
}