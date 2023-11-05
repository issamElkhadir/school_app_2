<?php

namespace Modules\Education\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class StudentAbsenceAuthorizationRequestRequest extends BaseFormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function commonRules(): array
  {
    return [
      'subscription.id' => 'required|exists:subscriptions,id',
      'accepted_by.id' => 'nullable|exists:users,id',
      'start_date' => 'required|date',
      'end_date' => 'required|date',
      'accepted' => 'required|boolean',
      'content' => 'nullable|string',
      'file' => 'nullable|string',
      'authorization_date' => 'nullable|date',
      'school.id' => 'required|exists:schools,id',
    ];
  }

  public function updateRules(): array
  {
    return [
      'subscription.id' => 'sometimes',
      'accepted_by.id' => 'sometimes',
      'start_date' => 'sometimes',
      'end_date' => 'sometimes',
      'accepted' => 'sometimes',
      'content' => 'sometimes',
      'file' => 'sometimes',
      'school.id' => 'sometimes',

    ];
  }

  public function attributes(): array
  {
    return [
      'subscription.id' => 'subscription',
      'school.id' => 'school',
    ];
  }

}
