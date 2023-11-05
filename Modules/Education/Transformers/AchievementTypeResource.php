<?php

namespace Modules\Education\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Education\Entities\AchievementType;

/** @mixin AchievementType * */
class AchievementTypeResource extends JsonResource
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
      'name' => $this->whenHas('name')
    ];
  }
}
