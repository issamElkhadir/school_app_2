<?php

namespace App\Http\Requests;

class CurrencyRequest extends BaseFormRequest
{
  public function commonRules(): array
  {
    return [
      'code' => 'required|string|max:255',
      'name' => 'required|string|max:255',
      'symbol' => 'required|string|max:255',
      'is_active' => 'required|boolean',
      'symbol_native' => 'required|string|max:255',
      'decimal_digits' => 'required|integer',
      'rounding' => 'required|decimal:2,4',
      'name_plural' => 'required|string|max:255',
    ];
  }

  public function updateRules(): array
  {
    return [
      'code' => 'sometimes',
      'name' => 'sometimes',
      'symbol' => 'sometimes',
      'is_active' => 'sometimes',
      'symbol_native' => 'sometimes',
      'decimal_digits' => 'sometimes',
      'rounding' => 'sometimes',
      'name_plural' => 'sometimes',
    ];
  }
}
