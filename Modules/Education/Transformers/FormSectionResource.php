<?php

namespace Modules\Education\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class FormSectionResource extends JsonResource
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
            'id' => $this->id,
            'title' => $this->whenHas('title'),
            'description' => $this->whenHas('description'),
            'order' => $this->whenHas('order'),
            'form' => new FormResource($this->whenLoaded('form')) ,
            'questions' => FormQuestionResource::collection($this->whenLoaded('questions'))
        ];
    }
}
