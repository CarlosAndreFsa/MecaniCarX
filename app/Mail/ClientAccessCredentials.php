<?php

namespace App\Mail;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClientAccessCredentials extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Customer $customer,
        public string $temporaryPassword,
        public string $loginUrl
    ) {}

    public function build(): self
    {
        return $this->subject('Seu acesso ao MecaniCarX')
            ->view('emails.client-access');
    }
}
