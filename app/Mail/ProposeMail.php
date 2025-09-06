<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProposeMail extends Mailable
{
    use Queueable, SerializesModels;

    /**

     * The user instance.

     *

     * @var User

     */

    public $name;

    /**

     * Create a new message instance.

     *

     * @return void

     */

    public function __construct($name)

    {
        $this->name = $name;
    }

    /**

     * Build the message.

     *

     * @return $this

     */

    public function build()

    {
        $data = [
            'to' => $this->name,
            'route' => route('admin::proposes')
        ];
        $email = $this->subject('[Nguyễn Văn Xuân Phú] Đề xuất sửa đổi')
            ->markdown('emails.propose')
            ->with('data', $data);
        return $email;
    }
}
