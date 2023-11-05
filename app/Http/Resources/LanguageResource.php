<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Language */
class LanguageResource extends JsonResource
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
      'has_translation' => $this->whenHas('has_translation', $this->has_translation),
      'direction' => $this->whenHas('direction', $this->direction),
      'local_code' => $this->whenHas('local_code', $this->local_code),
      'iso_code' => $this->whenHas('iso_code', $this->iso_code),
      'url_code' => $this->whenHas('url_code', $this->url_code),
      'status' => $this->whenHas('status', $this->status),
    ];
  }
}
