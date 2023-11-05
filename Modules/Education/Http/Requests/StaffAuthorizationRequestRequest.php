<?php

namespace Modules\Education\Http\Requests;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class StaffAuthorizationRequestRequest extends BaseFormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function commonRules(): array
  {
    return [
      'staff.id' => 'required|exists:staff,id',
      'responsible.id' => 'nullable|exists:users,id',
      'confirmed_date' => 'nullable|date',
      'content' => 'nullable|string',
      'start_date_time' => 'nullable|date_format:Y-m-d H:i:s',
      'end_date_time' => 'nullable|date_format:Y-m-d H:i:s',
      'note' => 'nullable|string',
      'school.id' => 'required|exists:schools,id',
    ];
  }

  public function updateRules(): array
  {
    return [
      'staff.id' => 'sometimes',
      'responsible.id' => 'sometimes',
      'confirmed_date' => 'sometimes',
      'content' => 'sometimes',
      'start_date_time' => 'sometimes',
      'end_date_time' => 'sometimes',
      'note' => 'sometimes',
      'school.id' => 'sometimes',
    ];
  }


  public function attributes(): array
  {
    return [
      'staff.id' => 'staff',
      'responsible.id' => 'responsible',
      'school.id' => 'school',
    ];
  }
}
