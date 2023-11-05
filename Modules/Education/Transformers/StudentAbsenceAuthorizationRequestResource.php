<?php

namespace Modules\Education\Transformers;

use App\Http\Resources\SchoolResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Education\Entities\StudentAbsenceAuthorizationRequest;

/** @mixin StudentAbsenceAuthorizationRequest * */
class StudentAbsenceAuthorizationRequestResource extends JsonResource
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
      'subscription' => new SubscriptionResource($this->whenLoaded('subscription')),
      'accepted_by' => new UserResource($this->whenLoaded('acceptedBy')),
      'start_date' => $this->whenHas('start_date', $this->start_date),
      'end_date' => $this->whenHas('end_date', $this->end_date),
      'accepted' => $this->whenHas('accepted', $this->accepted),
      'content' => $this->whenHas('content', $this->content),
      'file' => $this->whenHas('file', $this->file),
      'authorization_date' => $this->whenHas('authorization_date', $this->authorization_date),
      'school' => new SchoolResource($this->whenLoaded('school')),
    ];
  }
}
