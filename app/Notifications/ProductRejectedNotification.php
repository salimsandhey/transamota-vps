<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Product;

class ProductRejectedNotification extends Notification
{
    use Queueable;

    protected $product;
    protected $rejectionReason;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Product $product, $rejectionReason)
    {
        $this->product = $product;
        $this->rejectionReason = $rejectionReason;
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
            ->subject('Your Product Submission Has Been Rejected - Transamota')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('We regret to inform you that your product "' . $this->product->name . '" has been rejected during our verification process.')
            ->line('Reason for rejection: ' . $this->rejectionReason)
            ->line('You can edit your product and resubmit it for approval.')
            ->action('Edit Your Product', url('/seller/products/' . $this->product->id . '/edit'))
            ->line('If you have any questions, please contact our support team.')
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
            'rejection_reason' => $this->rejectionReason,
            'message' => 'Your product "' . $this->product->name . '" has been rejected. Reason: ' . $this->rejectionReason
        ];
    }
}