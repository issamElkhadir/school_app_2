<?php

namespace Modules\Education\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class ClassRequest extends BaseFormRequest
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
      'rtl_name' => 'string|max:255',
      'status' => 'boolean',
      'level.id' => 'required|integer|exists:levels,id',
      'school.id' => 'required|integer|exists:schools,id',
      'parentClass.id' => 'nullable|integer|exists:classes,id',
      'subjects' => 'array',
      'subjects.*.id' => 'required|exists:subjects,id',
    ];
  }

  public function storeRules(): array
  {
    return [
      'name' => 'unique:classes,name',
    ];
  }

  public function updateRules(): array
  {
    return [
      'name' => 'sometimes|unique:classes,name,' . $this->class->id,
      'level.id' => 'sometimes',
      'school.id' => 'sometimes',
      'parentClass.id' => 'sometimes',
    ];
  }

  public function attributes(): array
  {
    return [
      'level.id' => 'level',
      'school.id' => 'school',
      'parentClass.id' => 'parent class',
    ];
  }
}
