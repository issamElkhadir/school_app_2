<?php

namespace Modules\Education\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class AbsenceResource extends JsonResource
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
            'absence_type' => new AbsenceTypeResource($this->whenLoaded('absence_type')),
            'student' => new StudentResource($this->whenLoaded('student')),
            'achievement' => new AchievementResource($this->whenLoaded('achievement')),
            'subscription' => new SubscriptionResource($this->whenLoaded('subscription')),
            'note' => $this->whenHas('note' , $this->note),
            'date' => $this->whenHas('date' , $this->date) 
        ];
    }
}
