<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
            'matric_no' => 'string',
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'state' => 'string',
            'phone' => 'numeric',
            'email' => 'required|email',
            'image' => 'string',
//            'institution_id' => 'required|exists:institution,id',
        ];
    }
}
