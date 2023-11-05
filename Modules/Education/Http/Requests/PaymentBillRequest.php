<?php

namespace Modules\Education\Http\Requests;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;
use Modules\Education\Entities\PaymentBillLine;

class PaymentBillRequest extends BaseFormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
   */
  public function commonRules(): array
  {
    return [
      'sequence' => 'nullable|string|max:255',
      'untaxed_amount' => 'required|numeric',
      'tax_amount' => 'required|numeric',
      'total_amount' => 'required|numeric',
      'paid_amount' => 'required|numeric',
      'unpaid_amount' => 'required|numeric',
      'currency.id' => 'required|integer|exists:currencies,id',
      'subscription.id' => 'required|integer|exists:subscriptions,id',
      "lines" => 'required|array',
      "lines.*.id" => [
        'nullable',
        'integer',

        Rule::exists(PaymentBillLine::class, 'id')
          ->when($this->paymentBill, function ($rule, $value) {
            return $rule->where('payment_bill_id', $this->paymentBill->id);
          })
          ->withoutTrashed(),
      ],

      'lines.*.price_unit' => 'required|numeric',
      'lines.*.quantity' => 'required|numeric',
      'lines.*.vat' => 'required|numeric',
      //TODO:: check if exists in two tables hehe
      'lines.*.item' => 'required',
      //'lines.*.subtotal' => 'required|numeric',
      'lines.*.unit.id' => 'required|exists:measure_units,id',

    ];
  }

  public function updateRules(): array
  {
    return [
      'untaxed_amount' => 'sometimes',
      'tax_amount' => 'sometimes',
      'total_amount' => 'sometimes',
      'paid_amount' => 'sometimes',
      'unpaid_amount' => 'sometimes',
      'currency.id' => 'sometimes',
      'subscription.id' => 'sometimes',
      'lines.*.price_unit' => 'sometimes',
      'lines.*.quantity' => 'sometimes',
      'lines.*.vat' => 'sometimes',
      'lines.*.item' => 'sometimes',
      'lines.*.unit.id' => 'sometimes',
    ];
  }

  public function attributes(): array
  {
    return [
      'currency.id' => 'currency',
      'subscription.id' => 'subscription',
      'lines.*.unit.id' => 'unit',
    ];
  }
}
