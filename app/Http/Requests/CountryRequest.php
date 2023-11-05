<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class CountryRequest extends BaseFormRequest
{
  public function commonRules(): array
  {
    return [
      'name' => 'required|string|max:255',
      'iso3' => 'nullable|string|max:255',
      'numeric_code' => 'nullable|string|max:255',
      'iso2' => 'nullable|string|max:255',
      'phone_code' => 'nullable|string|max:255',
      'capital' => 'nullable|string|max:255',
      'currency' => 'nullable|string|max:255',
      'currency_name' => 'nullable|string|max:255',
      'currency_symbol' => 'nullable|string|max:255',
      'tld' => 'nullable|string|max:255',
      'native' => 'nullable|string|max:255',
      'region' => 'nullable|string|max:255',
      'subregion' => 'nullable|string|max:255',
      'timezones' => 'nullable|array',
      'timezones.*' => 'string|max:255',
      'translations' => 'nullable|array',
      'translations.*' => 'string|max:255',
      'latitude' => 'nullable|numeric|between:-90,90',
      'longitude' => 'nullable|numeric|between:-180,180',
      'emoji' => 'nullable|string|max:255',
      'emojiU' => 'nullable|string|max:255',
    ];
  }

  public function updateRules(): array
  {
    return [
      'name' => [
        'sometimes',
        Rule::unique('countries', 'name')
          ->ignore($this->country->id)
      ],
    ];
  }

  public function storeRules(): array
  {
    return [
      'name' => Rule::unique('countries', 'name'),
    ];
  }
}
