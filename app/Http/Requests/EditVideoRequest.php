<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditVideoRequest extends FormRequest
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
            'title' => 'required|min:5',
            'description' => 'required|min:10',
            'image' => 'mimes:jpeg,bmp,png,jpg',
            'video' => 'mimes:mp4',
        ];
    }
}
