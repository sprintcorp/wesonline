<?php

namespace App\Http\Requests\SuperAdmin;

use Illuminate\Foundation\Http\FormRequest;

class EmployerRequest extends FormRequest
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
            'name' => 'required|string',
            'location' => 'required|string',
            'industry' => 'required|string',
            'staff_name' => 'required|string',
            'staff_phone' => 'required|numeric',
            'email' => 'required|email|unique:employer',
            'description' => 'string',           
        ];
    }
}
