<?php

namespace App\Mail;

use App\Models\TeamInvite;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TeamInviteMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invite;

    /**
     * Create a new message instance.
     */
    public function __construct(TeamInvite $invite)
    {
        $this->invite = $invite;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Team Invite Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    public function build()
    {
        return $this->subject('Приглашение присоединиться к команде')
                    ->view('emails.team-invite');
    }
}
