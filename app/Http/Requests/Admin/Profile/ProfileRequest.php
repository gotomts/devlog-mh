<?php

namespace App\Http\Requests\Admin\Profile;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
        $rules = [
            'name'      => 'bail|required|max:64|',
            'email'     => 'bail|required|max:255|email|unique:users,email,' . \Auth::guard()->user()->id,
        ];
        $password = $this->password;
        if (isset($password)) {
            $rules['password'] = 'bail|min:8|max:16|';
        }
        return $rules;
    }
}
