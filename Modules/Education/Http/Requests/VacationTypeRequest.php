<?php

namespace Modules\Education\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class VacationTypeRequest extends BaseFormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
   */
  public function commonRules(): array
  {
    return [
      'school.id' => 'required|integer|exists:schools,id',
      'name' => 'required|string|max:255',
      'rtl_name' => 'nullable|string|max:255',
      'short_name' => 'nullable|string|max:50',
      'status' => 'boolean'
    ];
  }

  public function updateRules(): array
  {
    return [
      'school.id' => 'sometimes',
      'name' => 'sometimes|unique:vacation_types,name,' . $this->vacation_type->id,
      'rtl_name' => 'sometimes',
      'short_name' => 'sometimes',
      'status' => 'sometimes'
    ];
  }

  public function storeRules(): array
  {
    return [
      'name' => 'required|unique:vacation_types,name',
    ];
  }


  public function attributes(): array
  {
    return [
      'school.id' => 'school',
    ];
  }
}
