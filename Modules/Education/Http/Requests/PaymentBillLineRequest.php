<?php

namespace Modules\Education\Http\Requests;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class PaymentBillLineRequest extends BaseFormRequest
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
      'paymentBill.id' => 'required|integer|exists:payment_bills,id',
      'currency.id' => 'required|integer|exists:currencies,id',
      'unit.id' => 'required|integer|exists:measure_units,id',
      'price_unit' => 'required|numeric',
      'quantity' => 'required|numeric',
      'vat' => 'required|numeric',
      'subtotal' => 'required|numeric',
//      'item.id' => 'integer|exists:packs,id',

    ];
  }

  public function updateRules(): array
  {
    return [
      'name' => 'sometimes',
      'paymentBill.id' => 'sometimes',
      'currency.id' => 'sometimes',
      'unit.id' => 'sometimes',
      'price_unit' => 'sometimes',
      'quantity' => 'sometimes',
      'vat' => 'sometimes',
      'subtotal' => 'sometimes',
    ];
  }

  public function attributes(): array
  {
    return [
      'paymentBill.id' => 'payment bill',
      'currency.id' => 'currency',
      'unit.id' => 'unit',
      'item.id' => 'item (pack)',

    ];
  }
}
