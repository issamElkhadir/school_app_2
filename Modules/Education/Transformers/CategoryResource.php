<?php

namespace Modules\Education\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Education\Entities\Category;

/** @mixin Category */
class CategoryResource extends JsonResource
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
      'category' => new CategoryResource($this->whenLoaded('category')),
      'rtl_name' => $this->whenHas('rtl_name', $this->rtl_name),
      'short_name' => $this->whenHas('short_name', $this->short_name),
      'status' => $this->whenHas('status', $this->status),
      'description' => $this->whenHas('description', $this->description),

      'created_at' => $this->whenHas('created_at', $this->created_at),
      'updated_at' => $this->whenHas('updated_at', $this->updated_at),
    ];
  }
}
