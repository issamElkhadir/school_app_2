<?php

namespace App\Http\Resources;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin City */
class CityResource extends JsonResource
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
      'country' => CountryResource::make($this->whenLoaded('country')),
      'country_code' => $this->whenHas('country_code'),
      'state' => StateResource::make($this->whenLoaded('state')),
      'state_code' => $this->whenHas('state_code'),
      'latitude' => $this->whenHas('latitude'),
      'longitude' => $this->whenHas('longitude'),
      'flag' => $this->whenHas('flag'),
      'wikiDataId' => $this->whenHas('wikiDataId'),
    ];
  }
}
