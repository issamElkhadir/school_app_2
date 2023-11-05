<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\MeasureUnit */
class MeasureUnitResource extends JsonResource
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
      'category' => MeasureUnitCategoryResource::make($this->whenLoaded('category')),
      'active' => $this->whenHas('active', $this->active),
      'ratio' => $this->whenHas('ratio', $this->ratio),
      'type' => $this->whenHas('type', $this->type),
    ];
  }
}
