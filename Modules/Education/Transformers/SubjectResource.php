<?php

namespace Modules\Education\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Education\Entities\Classroom;
use Modules\Education\Entities\Subject;

/** @mixin Subject */
class SubjectResource extends JsonResource
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
      'unity' => new UnityResource($this->whenLoaded('unity')),
      'classroomType' => new ClassroomTypeResource($this->whenLoaded('classroomType')),
      'periods' => PeriodResource::collection($this->whenLoaded('periods')),
      'color' => $this->whenHas('color', $this->color),
      'picture' => $this->whenHas('picture', $this->picture),
      'massar_id' => $this->whenHas('massar_id', $this->massar_id),
      'order' => $this->whenHas('order', $this->order),
      'created_at' => $this->whenHas('created_at', $this->created_at),
      'updated_at' => $this->whenHas('updated_at', $this->updated_at),
    ];
  }
}
