<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class InternshipRequest extends FormRequest
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
            'description' => 'required|string',
            'requirement' => 'required|string',
            'video' => 'max:100000|mimes:mp4,avi,mkv',
            'document' => 'max:10240|mimes:doc,docx,pdf,txt',
            'task' => 'max:10240|mimes:doc,docx,pdf,txt',
            'resource_link' => 'string',
        ];
    }
}
