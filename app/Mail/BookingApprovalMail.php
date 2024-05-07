<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingApprovalMail extends Mailable
{
    use Queueable, SerializesModels;
    public $email, $content, $date,$booking_code,$origin,$destination,$pick_up_time,$departure_date,$passengers;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email,$content,$date,$booking_code,$origin,$destination,$pick_up_time,$departure_date,$passengers)
    {
        $this->email = $email;
        $this->content = $content;
        $this->date = $date;
        $this->booking_code = $booking_code;
        $this->origin = $origin;
        $this->destination = $destination;
        $this->pick_up_time = $pick_up_time;
        $this->departure_date = $departure_date;
        $this->pick_up_time = $pick_up_time;
        $this->passengers = $passengers;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Shuttlewiser Booking Approval',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            markdown: 'mail.booking-approval-mail',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
