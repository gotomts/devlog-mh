<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Member;

class MemberRegisterMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $member;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($member)
    {
        $this->member = $member;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('仮登録が完了しました')
            ->text('emails.front.member_register')
            ->with(['token' => $this->member['email_verify_token']]);
    }
}