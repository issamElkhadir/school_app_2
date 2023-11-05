<?php

namespace Modules\Education\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class SubscriptionRequest extends BaseFormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
   */
  public function commonRules(): array
  {
    return [
      'sequence' => 'nullable|string|max:255',
      'subscription_date' => 'date|nullable',
      'principal' => 'required|boolean',
      'class.id' => 'required|integer|exists:classes,id',
      'student.id' => 'required|integer|exists:students,id',
    ];
  }

  public function updateRules(): array
  {
    return [
      'principal' => 'sometimes',
      'class.id' => 'sometimes',
      'student.id' => 'sometimes',
    ];
  }

  public function attributes(): array
  {
    return [
      'class.id' => 'class',
      'student.id' => 'student',
    ];
  }
}
