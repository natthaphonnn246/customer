<?php

namespace App\Mail;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;
use Symfony\Component\Mime\Part\DataPart;

class StatusUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public int $statusId;
    public ?Customer $status = null;
    public string $checkUpdate;
    public $cidImage;


    public function __construct(int $statusId ,string $checkUpdate)
    {
        $this->statusId = $statusId;
        $this->checkUpdate = $checkUpdate;
    }

    public function build()
    {
        $this->status = Customer::find($this->statusId);

        if (!$this->status) {
            throw new \Exception("Customer not found for ID: " . $this->statusId);
        }

        if($this->checkUpdate === 'certstore') {

            $imageCertstore = storage_path('app/public/'.$this->status->cert_store);

            $cidImage = null; // ค่าเริ่มต้น

            if (!empty($this->status->cert_store) && is_file($imageCertstore)) {

                $this->withSymfonyMessage(function ($message) use ($imageCertstore, &$cidImage) {
                    $cidImage = $message->embedFromPath($imageCertstore);
                });
            }
        
            return $this->subject(
                            ' รหัสลูกค้า | '.$this->status->customer_id.
                            ' | ชื่อลูกค้า | '.$this->status->customer_name.
                            ' | ใบอนุญาตขายยา'
                        )
                        ->view('emails.status_updated_store')
                        ->with([
                            'status_store' => $this->status,
                            'cidImage' => $cidImage,
                        ]);
        
        
        } else if($this->checkUpdate === 'certmedical') {

            /* return $this->subject('รหัสลูกค้า' .' | '. $this->status->customer_id . ' '.'ชื่อลูกค้า'.' | '. $this->status->customer_name. ' '.' | '. 'ใบประกอบวิชาชีพ')
                        ->view('emails.status_updated_medical')
                        ->with([
                            'status_medical' => $this->status
                        ]); */

            $imageCertmedical = storage_path('app/public/'.$this->status->cert_medical);

            $cidImage = null; // ค่าเริ่มต้น

            if (!empty($this->status->cert_medical) && is_file($imageCertmedical)) {

                $this->withSymfonyMessage(function ($message) use ($imageCertmedical, &$cidImage) {
                    $cidImage = $message->embedFromPath($imageCertmedical);
                });
            }
        
            return $this->subject(
                            'รหัสลูกค้า | '.$this->status->customer_id.
                            ' ชื่อลูกค้า | '.$this->status->customer_name.
                            ' | ใบประกอบวิชาชีพ'
                        )
                        ->view('emails.status_updated_medical')
                        ->with([
                            'status_medical' => $this->status,
                            'cidImage' => $cidImage,
                        ]);
        }

            return $this->subject(
                            'รหัสลูกค้า' .' | '. $this->status->customer_id .
                            ' | '. 'ชื่อลูกค้า'.' | '. $this->status->customer_name.
                            ' | '. 'อัปเดตทั้งหมด'
                        )
                        ->view('emails.status_updated')
                        ->with([
                            'status' => $this->status
                        ]);

        
       
    }

}

