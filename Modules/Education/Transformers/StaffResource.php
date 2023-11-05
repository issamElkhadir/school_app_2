<?php

namespace Modules\Education\Transformers;

use App\Http\Resources\SchoolResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Education\Entities\Staff;

/** @mixin Staff */
class StaffResource extends JsonResource
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
      'email' => $this->whenHas('email', $this->email),
      'phone' => $this->whenHas('phone', $this->phone),
      'address' => $this->whenHas('address', $this->address),
      'salary' => $this->whenHas('salary', $this->salary),
      'week_hours' => $this->whenHas('week_hours', $this->week_hours),
      'schools' => SchoolResource::collection($this->whenLoaded('schools')),
      'skills' => SkillResource::collection($this->whenLoaded('skills')),
      'created_at' => $this->whenHas('created_at', $this->created_at),
      'updated_at' => $this->whenHas('updated_at', $this->updated_at),
    ];
  }
}
