<?php

namespace Modules\Education\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class PaymentScheduleRequest extends BaseFormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
   */
  public function commonRules(): array
  {
    return [
      'lines.*.*.amount_to_pay' => ['required', 'numeric', 'min:0'],
      'lines.*.*.amount_paid' => ['required', 'numeric', 'min:0'],
      'lines.*.*.payment_date' => ['required', 'date'],
    ];
  }

  public function attributes(): array
  {
    return [
      'lines.*.*.amount_to_pay' => 'amount to pay',
      'lines.*.*.amount_paid' => 'amount paid',
      'lines.*.*.payment_date' => 'payment date',
    ];
  }
}
