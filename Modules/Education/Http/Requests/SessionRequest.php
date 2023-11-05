<?php

namespace Modules\Education\Http\Requests;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class SessionRequest extends BaseFormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
   */
  public function commonRules(): array
  {
    return [
      'name' => 'required|unique:sessions|string|max:255',
      'start_time' => 'required',
      'end_time' => 'required',
      'day' => 'required|integer|between:1,7',
      'content' => 'nullable|string',
      'staff.id' => 'required|integer|exists:staff,id',
      'subject.id' => 'required|integer|exists:subjects,id',
      'classroom.id' => 'required|integer|exists:classrooms,id',
      'schedule.id' => 'required|integer|exists:schedules,id',
    ];
  }

  public function updateRules(): array
  {
    return [
      'name' => 'sometimes',
      'start_time' => 'sometimes',
      'end_time' => 'sometimes',
      'day' => 'sometimes',
      'staff.id' => 'sometimes',
      'subject.id' => 'sometimes',
      'classroom.id' => 'sometimes',
      'schedule.id' => 'sometimes',
    ];
  }

  public function attributes(): array
  {
    return [
      'staff.id' => 'staff',
      'subject.id' => 'subject',
      'classroom.id' => 'classroom',
      'schedule.id' => 'schedule',
    ];
  }
}
