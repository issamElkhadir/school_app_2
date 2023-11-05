<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\UserDefinedFilter */
class UserDefinedFilterResource extends JsonResource
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
      'model' => $this->whenHas('model', $this->model),
      'filters' => $this->whenHas('filters', $this->filters),
      'description' => $this->whenHas('description', $this->description),
      'is_default' => $this->whenHas('is_default', $this->is_default),
      'is_enabled' => $this->whenHas('is_enabled', $this->is_enabled),
    ];
  }
}
