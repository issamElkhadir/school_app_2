<?php

namespace Modules\Education\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class VacationRequest extends BaseFormRequest
{

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
   */
  public function commonRules(): array
  {
    return [
      'staff.id' => 'required|integer|exists:staff,id',
      'start_date' => 'required|date',
      'end_date' => 'required|date',
      'vacation_type.id' => 'required|integer|exists:vacation_types,id'
    ];
  }

  public function updateRules(): array
  {
    return [
      'staff.id' => 'sometimes',
      'start_date' => 'sometimes',
      'end_date' => 'sometimes',
      'vacation_type.id' => 'sometimes'
    ];
  }


  public function attributes(): array
  {
    return [
      'staff.id' => 'staff',
      'vacation_types.id' => 'vacation_types',

    ];
  }
}
