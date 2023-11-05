<?php

namespace Modules\Education\Transformers;

use App\Http\Resources\SchoolResource;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Education\Entities\VacationType;

/** @mixin VacationType */
class VacationTypeResource extends JsonResource
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
      'school' => new SchoolResource($this->whenLoaded('school')),
      'name' => $this->whenHas('name', $this->name),
      'rtl_name' => $this->whenHas('rtl_name', $this->rtl_name),
      'short_name' => $this->whenHas('short_name', $this->short_name),
      'status' => $this->whenHas('status', $this->status),
    ];
  }
}
