<?php

namespace App\Http\Resources\Company;

use Illuminate\Http\Resources\Json\JsonResource;

class InternshipResource extends JsonResource
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
            'company_email'=> $this->employer->email,
            'company_phone'=> $this->employer->phone,
            'company_name'=> $this->employer->name,
            'company_id'=> $this->employer->id,
            'name'=> $this->name,
            'slug'=> $this->slug,
            'requirement'=> $this->requirement,
            'video'=> $this->video,
            'video_description'=> $this->video_description,
            'task'=> $this->task,
            'description'=> $this->description,
            'document'=> $this->document,
            'resource_link'=> $this->resource_link,
            'created_at'=> $this->created_at,
            'updated_at'=> $this->updated_at,
        ];
    }
}
