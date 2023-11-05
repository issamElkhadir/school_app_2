<?php

namespace Modules\Education\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class SanctionTypeRequest extends BaseFormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function commonRules(): array
  {
    return [
      'school.id' => 'required|exists:schools,id',
      'name' => 'required|string|max:255',
      'rtl_name' => 'nullable|string|max:255',
      'short_name' => 'nullable|string|max:50',
      'description' => 'nullable|string',
      'status' => 'required|boolean',
    ];
  }

  public function updateRules(): array
  {
    return [
      'school.id' => 'sometimes',
      'name' => 'sometimes|unique:sanction_types,name,' . $this->sanction_type->id ,
      'status' => 'sometimes',
    ];
  }

  public function storeRules(): array
  {
    return [
      'name' => 'unique:sanction_types,name',
    ];
  }


  public function attributes(): array
  {
    return [
      'school.id' => 'school',
    ];
  }
}
