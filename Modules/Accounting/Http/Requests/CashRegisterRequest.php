<?php

namespace Modules\Accounting\Http\Requests;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

class CashRegisterRequest extends BaseFormRequest
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
      'initial_balance' => 'required|numeric',
      'status' => 'required|boolean',
      'owner.id' => 'required|exists:schools,id',
    ];
  }

  public function storeRules(): array
  {
    return [
      'name' => Rule::unique('cash_registers', 'name')
    ];
  }

  public function updateRules(): array
  {
    return [
      'name' => [
        'sometimes',
        Rule::unique('cash_registers', 'name')
          ->ignore($this->route('cash_register')->id)
      ],
      'initial_balance' => 'sometimes',
      'status' => 'sometimes',
      'owner.id' => 'sometimes',
    ];
  }

  public function attributes()
  {
    return [
      'owner.id' => 'school'
    ];
  }
}
