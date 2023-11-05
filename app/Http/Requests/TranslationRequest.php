<?php

namespace App\Http\Requests;

class TranslationRequest extends BaseFormRequest
{
   public function commonRules(): array
  {
    return [
      'language.id' => 'required|integer|exists:languages,id',
      'module' => 'nullable|string|max:255',
      'model' => 'nullable|string|max:255',
      'value' => 'required|string|max:255',
      'key' => 'required|string|max:255',
    ];
  }

  public function updateRules(): array
  {
    return [
      'language.id' => 'sometimes',
      'module' => 'sometimes',
      'model' => 'sometimes',
      'value' => 'sometimes',
      'key' => 'sometimes',
    ];
  }

  public function attributes()
  {
    return [
      'language.id' => 'language',
    ];
  }
}
