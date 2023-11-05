<?php

namespace Modules\Education\Transformers;

use App\Http\Resources\SchoolResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Education\Entities\StaffAuthorizationRequest;

/** @mixin StaffAuthorizationRequest * */
class StaffAuthorizationRequestResource extends JsonResource
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
      'staff' => new StaffResource($this->whenLoaded('staff')),
      'responsible' => new UserResource($this->whenLoaded('responsible')),
      'confirmed_date' => $this->whenHas('confirmed_date', $this->confirmed_date),
      'content' => $this->whenHas('content', $this->content),
      'start_date_time' => $this->whenHas('start_date_time', $this->start_date_time),
      'end_date_time' => $this->whenHas('end_date_time', $this->end_date_time),
      'note' => $this->whenHas('note', $this->note),
      'school' => new SchoolResource($this->whenLoaded('school')),
    ];
  }
}
