<?php

namespace App\Http\Resources;

use App\Models\City;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Translation */
class TranslationResource extends JsonResource
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
      'language' => new LanguageResource($this->whenLoaded('language')),
      'module' => $this->whenHas('module', $this->module),
      'model' => $this->whenHas('model', $this->model),
      'value' => $this->whenHas('value', $this->value),
      'key' => $this->whenHas('key', $this->key),

      'created_at' => $this->whenHas('created_at', $this->created_at),
      'updated_at' => $this->whenHas('updated_at', $this->updated_at),
    ];
  }
}
