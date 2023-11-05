<?php

namespace Modules\Education\Http\Requests;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;
use Modules\Education\Entities\Skill;

class StaffRequest extends BaseFormRequest
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
      'phone' => 'nullable||max:255',
      'email' => 'nullable|email|max:255',
      'address' => 'nullable|string',
      'salary' => 'nullable|numeric',
      'week_hours' => 'nullable|numeric',
      'schools' => 'required|array',
      'schools.*.id' => 'required|exists:schools,id',
      "skills" => 'nullable|array',
      "skills.*.id" => [
        'nullable',
        'integer',

        Rule::exists(Skill::class, 'id')
          ->when($this->staff, function ($rule, $value) {
            return $rule->where('staff_id', $this->staff->id);
          })
          ->withoutTrashed(),
      ],

      'skills.*.note' => 'nullable|string|max:255',
      'skills.*.level.id' => 'required|exists:levels,id',
      'skills.*.subject.id' => 'required|exists:subjects,id',
    ];
  }

  public function storeRules(): array
  {
    return [
      'name' => 'unique:staff,name',
    ];
  }

  public function updateRules(): array
  {
    return [
      'name' => 'sometimes|unique:staff,name,' . $this->staff->id,
      'schools' => 'sometimes',
      'schools.*.id' => 'sometimes',
      "skills" => 'sometimes',
      "skills.*.id" => 'sometimes',
      'skills.*.note' => 'sometimes',
      'skills.*.level.id' => 'sometimes',
      'skills.*.subject.id' => 'sometimes',
    ];
  }

  public function attributes(): array
  {
    return [
      'schools.*.id' => 'school',
      'skills.*.id' => 'skill',
    ];
  }
}
