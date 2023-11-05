<?php

namespace Modules\Education\Http\Requests;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class ClassroomTypeRequest extends BaseFormRequest
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
      'status' => 'boolean',
    ];
  }

  public function storeRules(): array
  {
    return [
      'name' => 'unique:classroom_types,name',
    ];
  }

  public function updateRules(): array
  {
    return [
      'name' => 'sometimes|unique:classroom_types,name,' . $this->classroom_type->id,
    ];
  }

}
