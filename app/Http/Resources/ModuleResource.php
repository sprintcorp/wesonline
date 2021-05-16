<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ModuleResource extends JsonResource
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
            'training' => $this->section->training->name,
            'section' => $this->section->name,
            'creator' => $this->user_type ? 'admin' : $this->user->employer->name,
            'name'=> $this->name,
            'description'=> $this->description,
            'module_url' => $this->module,
            'module_id'=> $this->module_id,
            'created_at'=> $this->created_at,
            'updated_at'=> $this->updated_at,
        ];
    }
}
