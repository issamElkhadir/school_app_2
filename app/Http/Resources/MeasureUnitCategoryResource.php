<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\MeasureUnitCategory */
class MeasureUnitCategoryResource extends JsonResource
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
      'units' => MeasureUnitResource::collection($this->whenLoaded('units')),
    ];
  }
}