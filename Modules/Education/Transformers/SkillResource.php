<?php

namespace Modules\Education\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Education\Entities\Skill;

/** @mixin Skill */
class SkillResource extends JsonResource
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
      'note' => $this->whenHas('note', $this->note),
      'staff' => new StaffResource($this->whenLoaded('staff')),
      'subject' => new SubjectResource($this->whenLoaded('subject')),
      'level' => new LevelResource($this->whenLoaded('level')),
    ];
  }
}
