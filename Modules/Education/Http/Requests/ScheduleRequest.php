<?php

namespace Modules\Education\Http\Requests;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

class ScheduleRequest extends BaseFormRequest
{

  public function commonRules(): array
  {
    return [
      'name' => 'required|string|max:255',
      'start_date' => 'nullable|date',
      'class.id' => 'required|exists:classes,id',
      'level.id' => 'required|exists:levels,id',
      'branch.id' => 'required|exists:branches,id',
      'active' => 'boolean|required',
    ];
  }

  public function storeRules(): array
  {
    return [
      'name' => 'unique:schedules,name',
    ];
  }

  public function updateRules(): array
  {
    return [
      'name' => 'sometimes|unique:schedules,name,' . $this->schedule->id,
      'class.id' => 'sometimes',
      'level.id' => 'sometimes',
      'branch.id' => 'sometimes',
      'active' => 'sometimes',
    ];
  }

  public function attributes(): array
  {
    return [
      'class.id' => 'class',
      'level.id' => 'level',
      'branch.id' => 'branch',
    ];
  }


}
