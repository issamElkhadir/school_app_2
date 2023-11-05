<?php

namespace Modules\Education\Transformers;

use App\Http\Resources\SchoolResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Education\Entities\Allergy;

/** @mixin Allergy */
class AllergyResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    return [
      'id' => $this->id,
      'name' => $this->whenHas('name', $this->name),
      'school' => SchoolResource::make($this->whenLoaded('school')),
      'allergy_type' => AllergyTypeResource::make($this->whenLoaded('allergy_type')),
      'short_name' => $this->whenHas('short_name', $this->short_name),
      'description' => $this->whenHas('description', $this->description),
      'rtl_name' => $this->whenHas('rtl_name', $this->rtl_name),
      'status' => $this->whenHas('status', $this->status),
    ];
  }
}
