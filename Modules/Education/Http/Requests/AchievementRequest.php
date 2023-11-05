<?php

namespace Modules\Education\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class AchievementRequest extends BaseFormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function commonRules(): array
  {
    return [
      'class.id' => 'required|exists:classes,id',
      'start_time' => 'required|date_format:H:i:s',
      'end_time' => 'required|date_format:H:i:s',
      'date' => 'nullable|date',
      'delay_time' => 'date_format:H:i:s',
      'is_realised' => 'boolean',
      'note' => 'nullable|string',
      'achievement_type.id' => 'required|exists:achievement_types,id',
      'school.id' => 'required|exists:schools,id',
      'achievable.achievable_type' => 'required|string',
      //TODO:: validate in two ways: 1. if achievable_type is education.session, then achievable_id must be a valid session id
      // 2. if achievable_type is education.catch-up, then achievable_id must be a valid catch-up id
      'achievable.achievable_id' => 'required|integer',
    ];
  }

  public function updateRules(): array
  {
    return [
      'class.id' => 'sometimes',
      'start_time' => 'sometimes',
      'end_time' => 'sometimes',
      'date' => 'sometimes',
      'delay_time' => 'sometimes',
      'is_realised' => 'sometimes',
      'note' => 'sometimes',
      'achievement_type.id' => 'sometimes',
      'school.id' => 'sometimes',
      'achievable_type' => 'sometimes',
      'achievable_id' => 'sometimes',
    ];
  }


  public function attributes(): array
  {
    return [
      'class.id' => 'class',
      'achievement_type.id' => 'achievement type',
      'school.id' => 'school'
    ];
  }
}
