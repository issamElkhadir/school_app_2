<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\SchoolResource;

/** @mixin \App\Models\Sequence */
class SequenceResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    return [
      'id' => $this->whenHas('id'),
      'name' => $this->whenHas('name'),
      'start_value' => $this->whenHas('start_value'),
      'end_value' => $this->whenHas('end_value'),
      'next_value' => $this->whenHas('next_value'),
      'length' => $this->whenHas('length'),
      'prefix' => $this->whenHas('prefix'),
      'suffix' => $this->whenHas('suffix'),
      'code' => $this->whenHas('code'),
      'step' => $this->whenHas('step'),
      'school' => SchoolResource::make($this->whenLoaded('school')),
    ];
  }
}
