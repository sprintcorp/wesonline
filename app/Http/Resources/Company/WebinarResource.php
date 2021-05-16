<?php

namespace App\Http\Resources\Company;

use Illuminate\Http\Resources\Json\JsonResource;

class WebinarResource extends JsonResource
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
            'image'=> $this->image,
            'date'=> $this->date,
            'time'=> $this->time,
            'slug'=> $this->slug,
            'host'=> $this->host,
            'description'=> $this->description,
            'industry'=> $this->industry,
            'created_at'=> $this->created_at,
            'updated_at'=> $this->updated_at,
        ];
    }
}
