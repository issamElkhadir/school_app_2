<?php

namespace Modules\Education\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class PaymentRequest extends BaseFormRequest
{
 /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
   */
  public function commonRules(): array
  {
    return [
      'sourceCashRegister.id' => 'required|exists:cash_registers,id',
      'destinationCashRegister.id' => 'required|exists:cash_registers,id',
      'payment_method' => 'required|numeric',
      'staff.id' => 'required|exists:staff,id',
      'currency.id' => 'exists:currencies,id',
      'customer.id' => 'exists:customers,id',
      'payable.id' => 'required|exists:subscriptions,id',
      'memo' => 'nullable|string',
      'amount' => 'required|numeric',
      'payment_date' => 'required|date',
    ];
  }

  public function updateRules(): array
  {
    return [
      'sourceCashRegister.id' => 'sometimes',
      'destinationCashRegister.id' => 'sometimes',
      'payment_method' => 'sometimes',
      'staff.id' => 'sometimes',
      'currency.id' => 'sometimes',
      'customer.id' => 'sometimes',
      'payable.id' => 'sometimes',
      'memo' => 'sometimes',
      'amount' => 'sometimes',
      'payment_date' => 'sometimes',
    ];
  }

  public function attributes(): array
  {
    return [
      'sourceCashRegister.id' => 'source cash register',
      'destinationCashRegister.id' => 'destination cash register',
      'staff.id' => 'staff',
      'currency.id' => 'currency',
      'customer.id' => 'customer',
      'payable.id' => 'payable',
    ];
  }
}
