<?php

namespace Modules\Education\Transformers;

use App\Http\Resources\SchoolResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Education\Entities\AppointmentRequest;

/** @mixin AppointmentRequest **/
class AppointmentRequestsResource extends JsonResource
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
      'school' => new SchoolResource($this->whenLoaded('school')),
      'staff' => new StaffResource($this->whenLoaded('staff')),
      'student' => new StudentResource($this->whenLoaded('student')),
      'guardian' => new GuardianResource($this->whenLoaded('guardian')),
      'title' => $this->whenHas('title', $this->title),
      'content' => $this->whenHas('content', $this->content),
      'accepted' => $this->whenHas('accepted', $this->accepted),
      'response' => $this->whenHas('response', $this->response),
      'appointment_date' => $this->whenHas('appointment_date', $this->appointment_date)
    ];
  }
}
