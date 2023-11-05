<?php

namespace Modules\Education\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class FormQuestionResource extends JsonResource
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
            'type' => $this->whenHas('type'),
            'description' => $this->whenHas('description'),
            'options' => $this->whenHas('options'),
            'is_required' => $this->whenHas('is_required'),
            'order' => $this->whenHas('order'),
            'points' => $this->whenHas('points'),
            'section' => new FormSectionResource($this->whenLoaded('section')) 
        ];
    }
}
