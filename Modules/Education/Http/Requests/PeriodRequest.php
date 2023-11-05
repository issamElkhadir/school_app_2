<?php

namespace Modules\Education\Http\Requests;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class PeriodRequest extends BaseFormRequest
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
      'start_date' => 'required|date|max:255',
      'end_date' => 'required|date|max:255',
      'status' => 'boolean',
    ];
  }

  public function storeRules(): array
  {
    return [
      'name' => 'unique:periods,name',
    ];
  }

  public function updateRules(): array
  {
    return [
      'name' => 'sometimes|unique:periods,name,' . $this->period->id,
      'end_date' => 'sometimes',
      'status' => 'sometimes',
    ];
  }

}
