<?php
namespace App\Utilities;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class EmailUtility extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct($data)
    {
        $this->data = $data;
    }
    public function build()
    {
        $from = env('MAIL_USERNAME');
        $name = env('MAIL_FROM_NAME');
        $data['contact_us'] = env('MAIL_CONTACTUS'); 
        $subject = $this->data['subject'] ?? '';
        $view = $this->data['view'] ?? '';
        $data = $this->data['details'] ?? '';
        
        return $this->view('emails.payment_confirmation', compact('data'))
            ->from($from, $name)
            ->subject($subject);  
    }
}
?>