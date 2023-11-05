<?php

namespace Modules\Education\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Education\Entities\AcademicYear;

/** @mixin AcademicYear */
class AcademicYearResource extends JsonResource
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
      'name' => $this->whenHas('name', $this->name),
      'rtl_name' => $this->whenHas('rtl_name', $this->rtl_name),
      'parentAcademicYear' => new AcademicYearResource($this->whenLoaded('parentAcademicYear')),
      'status' => $this->whenHas('status', $this->status),
      'isLocked' => $this->whenHas('is_locked', $this->is_locked),
      'start_date' => $this->whenHas('start_date', $this->start_date),
      'end_date' => $this->whenHas('end_date', $this->end_date),
      'parent_academic_year_name' => $this->whenHas('parent_academic_year_name', $this->parent_academic_year_name),

      'created_at' => $this->whenHas('created_at', $this->created_at),
      'updated_at' => $this->whenHas('updated_at', $this->updated_at),
    ];
  }
}
