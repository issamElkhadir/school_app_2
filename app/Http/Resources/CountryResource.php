<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Country */
class CountryResource extends JsonResource
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
      'iso3' => $this->whenHas('iso3'),
      'numeric_code' => $this->whenHas('numeric_code'),
      'iso2' => $this->whenHas('iso2'),
      'phone_code' => $this->whenHas('phone_code'),
      'capital' => $this->whenHas('capital'),
      'currency' => $this->whenHas('currency'),
      'currency_name' => $this->whenHas('currency_name'),
      'currency_symbol' => $this->whenHas('currency_symbol'),
      'tld' => $this->whenHas('tld'),
      'native' => $this->whenHas('native'),
      'region' => $this->whenHas('region'),
      'subregion' => $this->whenHas('subregion'),
      'timezones' => $this->whenHas('timezones'),
      'translations' => $this->whenHas('translations'),
      'latitude' => $this->whenHas('latitude'),
      'longitude' => $this->whenHas('longitude'),
      'emoji' => $this->whenHas('emoji'),
      'emojiU' => $this->whenHas('emojiU'),
      'cities' => CityResource::collection($this->whenLoaded('cities')),
      'cities_count' => $this->whenHas('cities_count'),
      'created_at' => $this->whenHas('created_at'),
      'updated_at' => $this->whenHas('updated_at'),
    ];
  }
}
