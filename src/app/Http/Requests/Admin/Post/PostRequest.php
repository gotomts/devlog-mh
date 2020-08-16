<?php

namespace App\Http\Requests\Admin\Post;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
        return [
            'title'         => 'bail|required|max:255',
            'url'           => "bail|required|max:255|unique:posts,url,$this->id",
            'keyword'       => 'bail|max:255',
            'description'   => 'bail|max:125',
            'category_id'   => 'bail|required',
            'status_id'     => 'bail|required',
        ];
    }
}
