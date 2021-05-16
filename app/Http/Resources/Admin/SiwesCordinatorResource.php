<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class SiwesCordinatorResource extends JsonResource
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
            'school_id'=> $this->institution->id,
            'school_name'=> $this->institution->name,
            'firstname'=> $this->firstname,
            'lastname'=> $this->lastname,
            'staff_id'=> $this->staff_id,
            'slug' => $this->slug,
            'phone'=> $this->staff_phone,
            'email'=> $this->email,
            'role'=> $this->users->role->name,
            'state'=> $this->state,
            'image'=>$this->image ? $this->image : 'No Image uploaded',
            'created_at'=> $this->created_at,
            'updated_at'=> $this->updated_at,
        ];
    }
}
