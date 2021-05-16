<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TrainingResource extends JsonResource
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
            'slug' => $this->slug,
            'creator' => $this->user_type ? 'admin' : $this->user->employer->name,
            'name'=> $this->name,
            'description'=> $this->description,
            'training' => $this->training,
            'no_of_section'=> $this->section ? count($this->section) : 0,
            'section'=> $this->section,
            'updated_at'=> $this->updated_at,
            'created_at'=> $this->created_at,
        ];
    }
}
