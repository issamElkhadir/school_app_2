<?php

namespace Modules\Education\Http\Requests;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class CycleRequest extends BaseFormRequest
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
      'short_name' => 'required|string|max:255',
      'rtl_name' => 'nullable|string|max:255',
      'description' => 'nullable|string',
      'status' => 'boolean',
      'schools' => 'required|array',
      'schools.*.id' => 'exists:schools,id',
    ];
  }

  public function storeRules(): array
  {
    return [
      'name' => 'unique:cycles,name',
    ];
  }

  public function updateRules(): array
  {
    return [
      'name' => 'sometimes|unique:cycles,name,' . $this->cycle->id,
      'schools' => 'sometimes|array',
      'short_name' => 'sometimes',
      'schools.*.id' => 'sometimes|exists:schools,id',
    ];
  }

}
