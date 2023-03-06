<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
// use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
	use Queueable, SerializesModels;

	public $request;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct(Request $request)
	{

		$this->request = $request;

	}

	/**
	 * Get the message envelope.
	 *
	 * @return \Illuminate\Mail\Mailables\Envelope
	 */
	public function envelope()
	{
		return new Envelope(
			from:env('MAIL_FROM_ADDRESS'),
			subject:'Contato do Site Medicus24h',
			replyTo:['address' => 'alissonguedes87@gmail.com']
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
			// view:'main.mails.contact_mail',
			// markdown:'main.mails.contact_mail',
			html:'main.mails.contact_mail',
			// text:'main.mails.contact_mail-text'
			with:[
				'url' => url('/'),
			]
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
