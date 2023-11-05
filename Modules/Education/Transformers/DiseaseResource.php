<?php

namespace Modules\Education\Transformers;

use App\Http\Resources\SchoolResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DiseaseResource extends JsonResource
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
      'id' => $this->whenHas('id'),
      'name' => $this->whenHas('name'),
      'description' => $this->whenHas('description'),
      'symptoms' => $this->whenHas('symptoms'),
      'treatment' => $this->whenHas('treatment'),
      'school' => SchoolResource::make($this->whenLoaded('school')),
    ];
  }
}
