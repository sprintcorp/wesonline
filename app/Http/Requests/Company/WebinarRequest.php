<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class WebinarRequest extends FormRequest
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
            'date' =>  'required|date|after:' . date('Y-m-d'),
            'time' => 'string',
            'host' => 'string',
            'image' => 'max:10240|mimes:png,jpeg,jiff,jpg',
            'industry' => 'string',
            'description' => 'string',
        ];
    }
}
