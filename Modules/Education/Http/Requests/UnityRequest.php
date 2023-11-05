<?php

namespace Modules\Education\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class UnityRequest extends BaseFormRequest
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
      'status' => 'boolean',
    ];
  }

  public function storeRules(): array
  {
    return [
      'name' => 'required|unique:unities|string|max:255',
    ];
  }

  public function updateRules(): array
  {
    return [
      'name' => 'sometimes|unique:unities,name,' . $this->unity->id,
    ];
  }

}
