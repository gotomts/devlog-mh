<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            $unique = 'unique:users,email,' . $this->id;
        } else {
            $unique = 'unique:users,email';
        }
        return [
            'name'      => 'bail|required|max:64|',
            'email'     => 'bail|required|max:255|email|' . $unique,
            'role_type' => 'bail|required|',
            'password'  => 'bail|required|min:8|max:16|',
        ];
    }
}
