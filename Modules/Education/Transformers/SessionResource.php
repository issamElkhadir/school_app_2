<?php

namespace Modules\Education\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Education\Entities\Session;

/** @mixin Session */
class SessionResource extends JsonResource
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
      'achievable_type' => 'education.session',
      'schedule' => new ScheduleResource($this->whenLoaded('schedule')),
      'classroom' => new ClassroomResource($this->whenLoaded('classroom')),
      'subject' => new SubjectResource($this->whenLoaded('subject')),
      'staff' => new StaffResource($this->whenLoaded('staff')),
      'start_time' => $this->whenHas('start_time', $this->start_time),
      'end_time' => $this->whenHas('end_time', $this->end_time),
      'day' => $this->whenHas('day', $this->day),
      'content' => $this->whenHas('content', $this->content),

    ];
  }
}
