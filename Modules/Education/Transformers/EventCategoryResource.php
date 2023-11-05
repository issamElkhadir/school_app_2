<?php

namespace Modules\Education\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class EventCategoryResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request
   * @return array
   */
  public function toArray($request)
  {
    return [
      'id' => $this->whenHas('id'),
      'name' => $this->whenHas('name'),
      'type' => $this->whenHas('type'),
      'icon' => $this->whenHas('icon'),
    ];
  }
}
