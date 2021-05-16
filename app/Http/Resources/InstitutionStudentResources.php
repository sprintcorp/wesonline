<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InstitutionStudentResources extends JsonResource
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
            'institution_id' => $this->id,
            'user_id' => $this->users->id,
            'email'=> $this->email,
            'institution_name'=> $this->name,
            'location'=> $this->location,
            'siwes_director'=> $this->siwes_director,
            'slug' => $this->slug,
            'phone'=> $this->staff_phone,
            'description'=> $this->description,
            'created_at'=> $this->created_at,
            'updated_at'=> $this->updated_at,
            'no_student_of_student'=> $this->student ? count($this->student):0,
            'students'=> $this->student,

        ];
    }
}
