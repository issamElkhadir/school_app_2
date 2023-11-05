<?php

namespace Modules\Education\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class AbsenceTypeResource extends JsonResource
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
      'rtl_name' => $this->whenHas('rtl_name'),
      'status' => $this->whenHas('status'),
    ];
  }
}
