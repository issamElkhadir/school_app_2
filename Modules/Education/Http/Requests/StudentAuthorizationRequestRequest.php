<?php

namespace Modules\Education\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class StudentAuthorizationRequestRequest extends BaseFormRequest
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
      'unity.id' => 'required|exists:unities,id',
      'authorized_by.id' => 'nullable|exists:users,id',
      'exempted' => 'boolean|required',
      'content' => 'nullable|string',
      'authorization_date' => 'nullable|date',
      'file' => 'nullable|string',
      'school.id' => 'required|exists:schools,id',
    ];
  }

  public function updateRules(): array
  {
    return [
      'subscription.id' => 'sometimes',
      'unity.id' => 'sometimes',
      'authorized_by.id' => 'sometimes',
      'exempted' => 'sometimes',
      'content' => 'sometimes',
      'authorization_date' => 'sometimes',
      'file' => 'sometimes',
      'school.id' => 'sometimes',
    ];
  }

  public function attributes(): array
  {
    return [
      'subscription.id' => 'user',
      'unity.id' => 'unity',
      'school.id' => 'school',
    ];
  }

}
