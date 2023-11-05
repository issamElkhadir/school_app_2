<?php

namespace Modules\Education\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class AchievementTypeRequest extends BaseFormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function commonRules(): array
  {
    return [
      'name' => 'required|string|max:255'
    ];
  }

  public function createRules(): array
  {
    return [
      'name' => 'unique:achievement_types,name',
    ];
  }

  public function updateRules(): array
  {
    return [
      'name' => 'sometimes|unique:achievement_types,name,' . $this->achievement_type->id,
    ];
  }


}
