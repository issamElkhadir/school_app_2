<?php

namespace Modules\Education\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class FormAnswerResource extends JsonResource
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
            'answer'=> $this->whenHas('answer'),
            'participator' => new ParticipatorResource($this->whenLoaded('participator')),
            'question' => new FormQuestionResource($this->whenLoaded('question')),
            'section' => new FormSectionResource($this->whenLoaded('section')),
        ];
    }
}
