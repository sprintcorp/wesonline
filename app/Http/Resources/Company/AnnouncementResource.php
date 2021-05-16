<?php

namespace App\Http\Resources\Company;

use Illuminate\Http\Resources\Json\JsonResource;

class AnnouncementResource extends JsonResource
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
            'title'=> $this->title,
            'details'=> $this->details,
            'slug'=> $this->slug,
            'created_at'=> $this->created_at,
            'updated_at'=> $this->updated_at,
        ];
    }
}
