<?php

namespace Modules\Education\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class AcademicYearRequest extends BaseFormRequest
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
      'start_date' => 'nullable|date',
      'end_date' => 'nullable|date',
      'status' => 'nullable|boolean',
      'is_locked' => 'boolean|required',
      'parent_academic_year.id' => 'nullable|integer|exists:academic_years,id',
      'parent_academic_year_name' => 'nullable|string|max:255',

    ];
  }

  public function updateRules(): array
  {
    return [
      'name' => 'sometimes',
      'is_locked' => 'sometimes',
    ];
  }

  public function attributes(): array
  {
    return [
      'parent_academic_year.id' => 'parent academic year',
    ];
  }
}
