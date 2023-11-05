<?php

namespace Modules\Education\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class CategoryRequest extends BaseFormRequest
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
      'description' => 'nullable|string',
      'status' => 'boolean',
      'category.id' => 'nullable|integer|exists:categories,id',
    ];
  }

  public function storeRules(): array
  {
    return [
      'name' => 'unique:categories,name',
    ];
  }

  public function updateRules(): array
  {
    return [
      'name' => 'sometimes|unique:categories,name,' . $this->category->id,
      'category.id' => 'sometimes',
    ];
  }

  public function attributes(): array
  {
    return [
      'category.id' => 'parent category',
    ];
  }
}
