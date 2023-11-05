<?php

namespace Modules\Education\Http\Requests;

use App\Http\Requests\BaseFormRequest;
use App\Rules\Base64Rule;

class ClassroomRequest extends BaseFormRequest
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
      'image' => [
        'nullable',
        Base64Rule::make()->maxSize(1024 * 2)
          ->mimeTypes('image/jpeg,image/png,image/jpg')
      ],
      'capacity' => 'required|integer|min:0',
      'school.id' => 'required|integer|exists:schools,id',
      'classroomType.id' => 'required|exists:classroom_types,id',


    ];
  }

  public function storeRules(): array
  {
    return [
      'name' => 'unique:classrooms,name',
    ];
  }

  public function updateRules(): array
  {
    return [
      'name' => 'sometimes|unique:classrooms,name,' . $this->classroom->id,
      'school.id' => 'sometimes',
      'capacity' => 'sometimes',
      'classroomType.id' => 'sometimes',
    ];
  }

  public function attributes(): array
  {
    return [
      'classroomType.id' => 'classroom type',
    ];
  }
}
