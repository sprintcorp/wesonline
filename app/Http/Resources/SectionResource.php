<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SectionResource extends JsonResource
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
            'training' => $this->training->name,
            'creator' => $this->user_type ? 'admin' : $this->user->employer->name,
            'name'=> $this->name,
            'description'=> $this->description,
            'module' => $this->module,
            'no_of_mocule'=> $this->section ? count($this->module) : 0,
            'created_at'=> $this->created_at,
            'updated_at'=> $this->updated_at,
        ];
    }
}
