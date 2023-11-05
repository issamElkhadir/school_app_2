<?php

namespace Modules\Education\Transformers;

use App\Http\Resources\SchoolResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PreInscriptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id ,
            'title' => $this->whenHas('title'),
            'slug' => $this->whenHas('slug') ,
            'description' => $this->whenHas('description'),
            'status' => $this->whenHas('status'),
            'start_date_time' => $this->whenHas('start_date_time'),
            'end_date_time' => $this->whenHas('end_date_time'),
            'form' => new FormResource($this->whenLoaded('form')), 
            'school' => new SchoolResource($this->whenLoaded('school')),
            'level' => new LevelResource($this->whenLoaded('level'))
        ];
    }
}
