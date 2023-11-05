<?php

namespace Modules\Education\Transformers;

use App\Http\Resources\SchoolResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Education\Entities\SanctionType;

/** @mixin SanctionType * */
class SanctionTypeResource extends JsonResource
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
      'rtl_name' => $this->whenHas('rtl_name', $this->rtl_name),
      'short_name' => $this->whenHas('short_name', $this->short_name),
      'description' => $this->whenHas('description', $this->description),
      'status' => $this->whenHas('status', $this->status),
      'school' => new SchoolResource($this->whenLoaded('school')),

    ];
  }
}
