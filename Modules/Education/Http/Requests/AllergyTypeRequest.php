<?php

namespace Modules\Education\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class AllergyTypeRequest extends BaseFormRequest
{

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
   */
  public function commonRules(): array
  {
    return [
      'name' => 'required|unique:allergy_types|string|max:255',
      'description' => 'nullable|string',
      'school.id' => 'required|integer|exists:schools,id',
      'symptoms' => 'required|string',
      'treatment' => 'required|string',
    ];
  }

  public function storeRules(): array
  {
    return [
      'name' => 'unique:allergy_types,name',
    ];
  }

  public function updateRules(): array
  {
    return [
      'name' => 'sometimes|unique:allergy_types,name,' . $this->allergy_type->id,
      'school.id' => 'sometimes',
      'description' => 'sometimes',
      'symptoms' => 'sometimes',
      'treatment' => 'sometimes',
    ];
  }


  public function attributes(): array
  {
    return [
      'school.id' => 'School',
    ];
  }

}
