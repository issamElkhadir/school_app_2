<?php

namespace Modules\Education\Transformers;

use App\Http\Resources\SchoolResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Education\Entities\Doctor;

/** @mixin Doctor * */
class DoctorResource extends JsonResource
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
      'name' => $this->whenHas('name', $this->name),
      'address' => $this->whenHas('address', $this->address),
      'phone' => $this->whenHas('phone', $this->phone),
      'email' => $this->whenHas('email', $this->email),
      'speciality' => $this->whenHas('speciality', $this->speciality)
    ];
  }
}
