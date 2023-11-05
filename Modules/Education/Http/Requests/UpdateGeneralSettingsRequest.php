<?php

namespace Modules\Education\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGeneralSettingsRequest extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'subscription_sequence.id' => 'required|exists:sequences,id',
      'payment_bill_sequence.id' => 'required|exists:sequences,id',
      'start_month' => 'required|integer|between:1,12',
      'end_month' => 'required|integer|between:1,12',
    ];
  }

  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  public function attributes()
  {
    return [
      'subscription_sequence.id' => 'subscription sequence',
      'payment_bill_sequence.id' => 'payment bill sequence',
      'start_month' => 'start month',
      'end_month' => 'end month',
    ];
  }
}
