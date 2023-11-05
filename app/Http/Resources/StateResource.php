<?php

namespace App\Http\Resources;

use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin State */
class StateResource extends JsonResource
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
      'country' => new CountryResource($this->whenLoaded('country')),
      'country_code' => $this->whenHas('country_code', $this->country_code),
      'fips_code' => $this->whenHas('fips_code', $this->fips_code),
      'iso2' => $this->whenHas('iso2', $this->iso2),
      'type' => $this->whenHas('type', $this->type),
      'latitude' => $this->whenHas('latitude', $this->latitude),
      'longitude' => $this->whenHas('longitude', $this->longitude),
      'flag' => $this->whenHas('flag', $this->flag),
      'wikiDataId' => $this->whenHas('wikiDataId', $this->wikiDataId),
      'created_at' => $this->whenHas('created_at', $this->created_at),
      'updated_at' => $this->whenHas('updated_at', $this->updated_at),
    ];
  }
}
