<?php

namespace Modules\Education\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class AllergyRequest extends BaseFormRequest
{

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
   */
  public function commonRules(): array
  {
    return [
      'name' => 'required|string|max:255',
      'rtl_name' => 'nullable|string|max:255',
      'short_name' => 'nullable|string|max:255',
      'description' => 'nullable|string',
      'school.id' => 'required|integer|exists:schools,id',
      'allergy_type.id' => 'required|integer|exists:allergy_types,id',
      'status' => 'required|boolean',
    ];
  }

  public function storeRules(): array
  {
    return [
      'name' => 'unique:allergies,name',
    ];
  }

  public function updateRules(): array
  {
    return [
      'name' => 'sometimes|unique:allergies,name,' . $this->allergy->id,
      'school.id' => 'sometimes',
      'allergy_type.id' => 'sometimes',
      'status' => 'sometimes',
      'rtl_name' => 'sometimes',
      'short_name' => 'sometimes',
    ];
  }

  public function attributes(): array
  {
    return [
      'school.id' => 'School',
      'allergy_type.id' => 'Allergy Type',
    ];
  }

}
