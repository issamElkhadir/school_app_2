<?php

namespace App\Http\Requests;

class StateRequest extends BaseFormRequest
{
  public function commonRules(): array
  {
    return [
      'name' => 'required|string|max:255',
      'country.id' => 'required|integer|exists:countries,id',
      'country_code' => 'required|string|max:2',
      'fips_code' => 'nullable|string|max:255',
      'iso2' => 'nullable|string|max:2',
      'type' => 'nullable|string|max:255',
      'latitude' => 'required|numeric|between:-90,90',
      'longitude' => 'required|numeric|between:-180,180',
      'flag' => 'required|boolean',
      'wikiDataId' => 'nullable|string|max:255',
    ];
  }

  public function updateRules(): array
  {
    return [
      'name' => 'sometimes',
      'country.id' => 'sometimes',
      'country_code' => 'sometimes',
      'latitude' => 'sometimes',
      'longitude' => 'sometimes',
      'flag' => 'sometimes',
    ];
  }

  public function attributes()
  {
    return [
      'country.id' => 'country',
      'country_code' => 'country code',
      'fips_code' => 'fips code',
      'wikiDataId' => 'wiki data id',
    ];
  }
}
