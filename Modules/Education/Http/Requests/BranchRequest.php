<?php

namespace Modules\Education\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class BranchRequest extends BaseFormRequest
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
      'short_name' => 'nullable|string|max:255',
      'description' => 'nullable|string',
      'status' => 'boolean',
      'cycle.id' => 'required|integer|exists:cycles,id',
    ];
  }

  public function updateRules(): array
  {
    return [
      'name' => 'sometimes|unique:branches,name,' . $this->branch->id,
      'cycle.id' => 'sometimes',
    ];
  }

  public function storeRules(): array
  {
    return [
      'name' => 'unique:branches,name',
    ];
  }

  public function attributes(): array
  {
    return [
      'cycle.id' => 'cycle',
    ];
  }
}
