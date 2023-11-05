<?php

namespace Modules\Education\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class EventCategoryRequest extends BaseFormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function commonRules(): array
  {
    return [
      'name' => 'required|string',
      'type' => 'required|string',
      'icon' => 'required|string',
    ];
  }

  public function storeRules(): array
  {
    return [
      'name' => 'unique:event_categories,name',
    ];
  }

  public function updateRules(): array
  {
    return [
      'type' => 'sometimes',
      'icon' => 'sometimes',
      'name' => 'sometimes|unique:event_categories,name,' . $this->event_category->id,
    ];
  }
}
