<?php

namespace App\Http\Requests;

class CityRequest extends BaseFormRequest
{
  public function commonRules(): array
  {
    return [
      'name' => 'required|string|max:255',
      'country.id' => 'required|integer|exists:countries,id',
      'country_code' => 'required|string|max:2',
      'state.id' => 'required|integer|exists:states,id',
      'state_code' => 'required|string|max:2',
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
      'state.id' => 'sometimes',
      'state_code' => 'sometimes',
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
      'state.id' => 'state',
      'state_code' => 'state code',
      'wikiDataId' => 'wiki data id',
    ];
  }
}
