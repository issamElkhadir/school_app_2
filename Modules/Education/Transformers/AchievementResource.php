<?php

namespace Modules\Education\Transformers;

use App\Http\Resources\SchoolResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Education\Entities\Achievement;
use Modules\Education\Entities\Session;

/** @mixin Achievement  * */
class AchievementResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param \Illuminate\Http\Request
   * @return array
   */
  public function toArray($request)
  {
    if (isset($this->achievable)) {
      $resource = match (get_class($this->achievable)) {
        Session::class => ['education/sessions', SessionResource::make($this)->toArray($request)],
        // CatchUp::class => ['education/catchups', CatchUpResource::make($this)->toArray($request)],
        default => null
      };
    }

    return [
      'id' => $this->id,
      // 'achievable' => $this->whenHas('achievable', $this->achievable),
      'achievable' => $resource[1] ?? null,
      'class' => new ClassResource($this->whenLoaded('class')),
      'achievement_type' => new AchievementTypeResource($this->whenLoaded('achievementType')),
      'school' => new SchoolResource($this->whenLoaded('school')),
      'start_time' => $this->whenHas('start_time', $this->start_time),
      'end_time' => $this->whenHas('end_time', $this->end_time),
      'date' => $this->whenHas('date', $this->date),
      'is_realised' => $this->whenHas('is_realised', $this->is_realised),
      'delay_time' => $this->whenHas('delay_time', $this->delay_time),
      'note' => $this->whenHas('note', $this->note),
    ];
  }
}
