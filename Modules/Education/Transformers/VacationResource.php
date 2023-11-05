<?php

namespace Modules\Education\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Education\Entities\Vacation;

/** @mixin Vacation */
class VacationResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    return [
      'id' => $this->id,
      'staff' => new StaffResource($this->whenLoaded('staff')),
      'start_date' => $this->whenHas('start_date', $this->start_date),
      'end_date' => $this->whenHas('end_date', $this->end_date),
      'vocation_type' => new VacationTypeResource($this->whenLoaded('vocationType')),
    ];
  }
}
