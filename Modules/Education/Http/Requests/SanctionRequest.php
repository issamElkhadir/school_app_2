<?php

namespace Modules\Education\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class SanctionRequest extends BaseFormRequest
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
      'date' => 'required|date',
      'reason' => 'nullable|string|max:255',
      'description' => 'nullable|string',
      'decision' => 'nullable|string|max:255',
      'sanction_type.id' => 'required|exists:sanction_types,id',
    ];
  }

  public function updateRules(): array
  {
    return [
      'staff.id' => 'sometimes',
      'date' => 'sometimes',
      'sanction_type.id' => 'sometimes',
    ];
  }

  public function attributes(): array
  {
    return [
      'staff.id' => 'staff',
      'sanction_type.id' => 'sanction type',
    ];
  }
}
