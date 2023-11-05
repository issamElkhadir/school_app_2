<?php

namespace Modules\Education\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ParticipatorResource extends JsonResource
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
            'first_name' => $this->whenHas('first_name'),
            'last_name' => $this->whenHas('last_name'),
            'email' => $this->whenHas('email'),
            'password' => $this->whenHas('password'),
            'token' => $this->whenHas('token'),
            'student' => new StudentResource($this->whenLoaded('student')),
            'form' => new FormResource($this->whenLoaded('form'))
        ];
    }
}
