<?php

namespace App\Http\Requests;

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
        return [
            // 'user_id'      => 'required|numeric',
            'user_id'      => 'numeric|nullable',
            'profile_id'   => 'numeric|nullable',
            'address'      => 'max:255|nullable',
            'job'          => 'max:255|nullable',
            'salary'       => 'max:255|nullable',
            'nomad_flag'   => 'numeric|nullable',
            'smoke_flag'   => 'numeric|nullable',
            'alcohol_flag' => 'numeric|nullable',
            'introduce'    => 'max:255|nullable',
            'image_path'   => 'max:255|nullable',
            'mail_text'    => 'max:255|nullable',
            'profile_name' => 'max:255|nullable',
            'from_email'   => 'max:255',

        ];
    }
}
