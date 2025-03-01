<?php

namespace Webkul\Email\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Mime\Email as MimeEmail;

class Email extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new email instance.
     *
     * @return void
     */
    public function __construct(public $email) {}

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $replyToEmail = env('MAIL_REPLY_TO_ADDRESS', env('MAIL_FROM_ADDRESS')); // Busca o reply-to do .env ou usa o MAIL_FROM_ADDRESS como fallback
        $replyToName = env('MAIL_REPLY_TO_NAME', env('MAIL_FROM_NAME')); // Busca o nome para reply-to
    
        $this->from($this->email->from)
            ->to($this->email->reply_to)
            ->replyTo($replyToEmail, $replyToName) // Usa o endereço e o nome configurados no .env
            ->cc($this->email->cc ?? [])
            ->bcc($this->email->bcc ?? [])
            ->subject($this->email->parent_id ? $this->email->parent->subject : $this->email->subject)
            ->html($this->email->reply);
    
        $this->withSymfonyMessage(function (MimeEmail $message) {
            $message->getHeaders()->addIdHeader('Message-ID', $this->email->message_id);
    
            $message->getHeaders()->addTextHeader('References', $this->email->parent_id
                ? implode(' ', $this->email->parent->reference_ids)
                : implode(' ', $this->email->reference_ids)
            );
        });
    
        foreach ($this->email->attachments as $attachment) {
            $this->attachFromStorage($attachment->path);
        }
    
        return $this;
    }
    
    
}
