<?php

namespace App\Http\Requests\Front\Member;

use Illuminate\Foundation\Http\FormRequest;

/**
 * MemberRequestクラス
 * 会員情報編集フォームバリデーション
 */
class MemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->id) {
            $unique = 'unique:members,email,' . $this->id;
        } else {
            $unique = 'unique:members,email';
        }
        return [
            'name' => 'bail|required|max:64|',
            'email' => 'bail|required|max:255|email|' . $unique,
            'old_password' => 'bail|password:member|nullable|min:8|max:16|',
            'new_password' => 'bail|nullable|min:8|max:16|required_with:old_password|confirmed',
            'new_password_confirmation' => 'bail|nullable|min:8|max:16|',
        ];
    }
}
