<?php

namespace App\Http\Resources\Company;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' => $this->users->id,
            'email'=> $this->email,
            'firstname'=> $this->firstname,
            'lastname'=> $this->lastname,
            'slug'=> $this->slug,
            'gender'=> $this->gender,
            'phone'=> $this->phone,
            'company_name'=> $this->employer->name,
            'company_id'=> $this->employer_id,
            'role'=> $this->users->role->name,
            'created_at'=> $this->created_at,
            'updated_at'=> $this->updated_at,
        ];
    }
}
