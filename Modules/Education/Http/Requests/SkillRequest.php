<?php

namespace Modules\Education\Http\Requests;


use App\Http\Requests\BaseFormRequest;

class SkillRequest extends BaseFormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
   */
  public function commonRules(): array
  {
    return [
      'note' => 'nullable|string|max:255',
      'staff.id' => 'required|integer|exists:staff,id',
      'subject.id' => 'required|integer|exists:subjects,id',
      'level.id' => 'required|integer|exists:levels,id',
    ];
  }

  public function updateRules(): array
  {
    return [
      'note' => 'sometimes',
      'staff.id' => 'sometimes',
      'subject.id' => 'sometimes',
      'level.id' => 'sometimes',
    ];
  }

  public function attributes(): array
  {
    return [
      'staff.id' => 'staff',
      'subject.id' => 'subject',
      'level.id' => 'level',
    ];
  }
}
