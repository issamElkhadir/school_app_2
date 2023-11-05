<?php

namespace Modules\Education\Transformers;

use App\Http\Resources\SchoolResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Education\Entities\AllergyType;

/** @mixin AllergyType */
class AllergyTypeResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param \Illuminate\Http\Request
   * @return array
   */
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'name' => $this->whenHas('name', $this->name),
      'school' => SchoolResource::make($this->whenLoaded('school')),
      'description' => $this->whenHas('description', $this->description),
      'symptoms' => $this->whenHas('symptoms', $this->symptoms),
      'treatment' => $this->whenHas('treatment', $this->treatment),
    ];
  }
}
