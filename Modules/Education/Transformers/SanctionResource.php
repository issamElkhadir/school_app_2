<?php

namespace Modules\Education\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Education\Entities\Sanction;

/** @mixin Sanction * */
class SanctionResource extends JsonResource
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
      'date' => $this->whenHas('date', $this->date),
      'reason' => $this->whenHas('reason', $this->reason),
      'description' => $this->whenHas('description', $this->description),
      'decision' => $this->whenHas('decision', $this->decision),
      'staff' => new StaffResource($this->whenLoaded('staff')),
      'sanction_type' => new SanctionTypeResource($this->whenLoaded('sanctionType')),
    ];
  }
}
