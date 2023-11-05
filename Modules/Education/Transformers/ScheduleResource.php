<?php

namespace Modules\Education\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Education\Entities\Schedule;

/** @mixin Schedule * */
class ScheduleResource extends JsonResource
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
      'start_date' => $this->whenHas('start_date', $this->start_date),
      'class' => new ClassResource($this->whenLoaded('class')),
      'level' => new LevelResource($this->whenLoaded('level')),
      'branch' => new BranchResource($this->whenLoaded('branch')),
      'active' => $this->whenHas('active', $this->active),
    ];
  }
}
