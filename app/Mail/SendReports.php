<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;


class SendReports extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $sender;
    protected $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Build the message.
     *
     * @return $this
     * 
     * instead of ->with() we can use ->attachFromStorageDisk() or ->aatachData()
     */
    public function build()
    {
        return $this
            ->from('example@example.com', 'Example')
            ->subject("Subject of the email")
            ->with([
                'email_body'=>$this->data
            ])
            ->view('emailReport');
    }

    public function go(self $sendReport, $emailData){

        $this->data = $emailData;
        
        Mail::to("requested@example.com")->send($sendReport);
        //Mail::to("requested@example.com")->queue($sendReport);

    }
}
