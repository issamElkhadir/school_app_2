<?php

namespace Modules\Education\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class DiseaseRequest extends BaseFormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function commonRules(): array
  {
    return [
      'name' => 'required|string|max:255',
      'description' => 'nullable|string|max:255',
      'symptoms' => 'required|string|max:255',
      'treatment' => 'required|string|max:255',
      'school.id' => 'required|exists:schools,id'
    ];
  }

  public function updateRules(): array
  {
    return [
      'name' => 'sometimes',
      'symptoms' => 'sometimes',
      'treatment' => 'sometimes',
      'school.id' => 'sometimes',
    ];
  }

  public function attributes()
  {
    return [
      'school.id' => 'school'
    ];
  }
}
