<?php

namespace Modules\Education\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class SubjectSequenceRequest extends BaseFormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
   */
  public function commonRules(): array
  {
    return [
      'content' => 'nullable|string|max:255',
      'nbh' => 'nullable|string|max:255',
      'status' => 'boolean',
      'subject.id' => 'required|integer|exists:subjects,id',
    ];
  }

  public function updateRules(): array
  {
    return [
      'subject.id' => 'sometimes',
    ];
  }

  public function attributes()
  {
    return [
      'subject.id' => 'Subject',
    ];
  }
}
