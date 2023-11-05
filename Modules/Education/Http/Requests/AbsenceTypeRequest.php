<?php

namespace Modules\Education\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class AbsenceTypeRequest extends BaseFormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function commonRules(): array
  {
    return [
      'name' => ['required', 'string', 'max:255'],
      'rtl_name' => ['nullable', 'string', 'max:255'],
      'status' => ['required', 'boolean']
    ];
  }

  public function createRules(): array
  {
    return [
      'name' => 'unique:absence_types,name',];
  }

  public function updateRules(): array
  {
    return [
      'name' => 'sometimes|unique:absence_types,name,' . $this->absenceType->id,
      'status' => 'sometimes',
    ];
  }
}
