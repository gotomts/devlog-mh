<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * 会員登録完了
 */
class MemberRegisterCompleteMail extends Mailable
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
            ->subject('会員登録が完了しました。')
            ->text('emails.front.member_register_complete')
            ->with(['name' => $this->member['name']]);
    }
}
