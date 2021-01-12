<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * 仮会員登録完了メール
 */
class MemberVerifyMail extends Mailable
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
            ->subject('登録を完了してください。')
            ->text('emails.front.member_verify')
            ->with(['name' => $this->member['name']])
            ->with(['token' => $this->member['email_verify_token']]);
    }
}
