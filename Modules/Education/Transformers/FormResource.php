<?php

namespace Modules\Education\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class FormResource extends JsonResource
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
            'name' => $this->whenHas('name'),
            'slug' => $this->whenHas('slug'),
            'description' => $this->whenHas('description'),
            'duration' => $this->whenHas('duration'),
            'is_active' => $this->whenHas('is_active'),
            'preferences' => $this->whenHas('preferences'),
            'sections' => FormSectionResource::collection($this->whenLoaded('sections'))
        ];
    }
}
