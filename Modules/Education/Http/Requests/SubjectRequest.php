<?php

namespace Modules\Education\Http\Requests;

use App\Http\Requests\BaseFormRequest;
use App\Rules\Base64Rule;

class SubjectRequest extends BaseFormRequest
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
      'color' => 'nullable|string|max:255',
      'order' => 'nullable|string|max:255',
      'massar_id' => 'required|integer',
      'unity.id' => 'required|integer|exists:unities,id',
      'classroomType.id' => 'required|integer|exists:classroom_types,id',
      'periods' => 'array',
      'periods.*.id' => 'required|exists:periods,id',

      'picture' => [
        'nullable',
        Base64Rule::make()->maxSize(1024 * 2)
          ->mimeTypes('image/jpeg', 'image/png', 'image/jpg')
      ]
    ];
  }

  public function storeRules(): array
  {
    return [
      'name' => 'unique:subjects,name',
    ];
  }

  public function updateRules(): array
  {
    return [
      'name' => 'sometime|unique:subjects,name,' . $this->subject->id,
      'color' => 'sometimes',
      'massar_id' => 'sometimes',
      'unity.id' => 'sometimes',
      'classroomType.id' => 'sometimes',
      'periods' => 'sometimes',
      'periods.*.id' => 'sometimes',
    ];
  }

  public function attributes(): array
  {
    return [
      'unity.id' => 'Unity',
      'classroomType.id' => 'Classroom Type',

    ];
  }
}
