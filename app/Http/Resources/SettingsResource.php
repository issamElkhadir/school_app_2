<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SettingsResource extends ResourceCollection
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    return $this->resource->mapWithKeys(function ($class) {
      /** @var \Spatie\LaravelSettings\Settings */
      $settings = app($class);

      return [
        $settings->group() => $settings->toArray()
      ];
    })->toArray();
  }
}
