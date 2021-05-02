<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployerResources extends JsonResource
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
            'company_name'=> $this->name,
            'location'=> $this->location,
            'industry'=> $this->industry,
            'staff'=> $this->staff_name,
            'slug' => $this->slug,
            'phone'=> $this->staff_phone,
            'description'=> $this->description,
            'role'=> $this->users->role->name,
            'created_at'=> $this->created_at,
            'updated_at'=> $this->updated_at,
        ];
    }
}
