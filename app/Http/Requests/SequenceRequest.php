<?php

namespace App\Http\Requests;

class SequenceRequest extends BaseFormRequest
{
  public function commonRules(): array
  {
    return [
      'name' => 'required|string|max:255',
      'school.id' => 'required|integer|exists:schools,id',
      'code' => 'required|string|max:255',
      'prefix' => 'nullable|string|max:255',
      'suffix' => 'nullable|string|max:255',
      'length' => 'nullable|integer',
      'next_value' => 'nullable|integer',
      'step' => 'nullable|integer',
      'start_value' => 'nullable|integer',
      'end_value' => 'nullable|integer',
    ];
  }

  public function updateRules(): array
  {
    return [
      'name' => 'sometimes',
      'school.id' => 'sometimes',
      'code' => 'sometimes',
    ];
  }

  public function attributes()
  {
    return [
      'school.id' => 'school'
    ];
  }
}
