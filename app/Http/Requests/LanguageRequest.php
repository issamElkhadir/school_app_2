<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LanguageRequest extends BaseFormRequest
{
  public function commonRules(): array
  {
    return [
      'name' => 'required|string',
      'has_translation' => 'required|boolean',
      'direction' => 'required|string|in:ltr,rtl',
      'local_code' => 'required|string',
      'iso_code' => 'required|string',
      'url_code' => 'required|string',
      'status' => 'required|boolean',
    ];
  }

  public function updateRules(): array
  {
    return [
      'name' => 'sometimes',
      'has_translation' => 'sometimes',
      'direction' => 'sometimes',
      'local_code' => 'sometimes',
      'iso_code' => 'sometimes',
      'url_code' => 'sometimes',
      'status' => 'sometimes',
    ];
  }
}
