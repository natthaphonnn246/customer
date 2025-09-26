<?php

namespace App\Mail;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegisterUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public int $statusCode;
    public ?Customer $status = null;
    public string $checkUpdate;
    public $cidImage;

    public function __construct(string $statusCode)
    {
        $this->statusCode = $statusCode;
        // $this->checkUpdate = $checkUpdate;
    }

    public function build()
    {
        $this->status = Customer::where('customer_id',$this->statusCode)->first();

        if (!$this->status) {
            throw new \Exception("Customer not found for ID: " . $this->statusCode);
        }

            return $this->subject(
                            'รหัสลูกค้า | '.$this->status->customer_id.
                            ' ชื่อลูกค้า | '.$this->status->customer_name.
                            ' | ลงทะเบียนใหม่'
                        )
                        ->view('emails.status_register')
                        ->with([
                            'status' => $this->status,
                        ]);
        
       
    }

}
