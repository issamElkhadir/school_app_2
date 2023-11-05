<?php

namespace Modules\Education\Transformers;

use App\Http\Resources\SchoolResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Education\Entities\Classroom;

/** @mixin Classroom */
class ClassroomResource extends JsonResource
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
      'school' => SchoolResource::make($this->whenLoaded('school')),
      'classroomType' => ClassroomTypeResource::make($this->whenLoaded('classroomType')),
      'capacity' => $this->whenHas('capacity', $this->capacity),
      'image' => $this->whenHas('image', $this->image),
      'rtl_name' => $this->whenHas('rtl_name', $this->rtl_name),
      'created_at' => $this->whenHas('created_at', $this->created_at),
      'updated_at' => $this->whenHas('updated_at', $this->updated_at),
    ];
  }
}
