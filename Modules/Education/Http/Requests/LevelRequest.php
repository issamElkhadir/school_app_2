<?php

namespace Modules\Education\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class LevelRequest extends BaseFormRequest
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
      'branch.id' => 'required|integer|exists:branches,id',
    ];
  }

  public function storeRules(): array
  {
    return [
      'name' => 'unique:levels,name',
    ];
  }

  public function updateRules(): array
  {
    return [
      'name' => 'sometimes|unique:levels,name,' . $this->level->id,
      'branch.id' => 'sometimes',
    ];
  }

  public function attributes(): array
  {
    return [
      'branch.id' => 'Branch',
    ];
  }
}
