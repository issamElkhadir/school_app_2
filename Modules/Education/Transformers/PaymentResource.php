<?php

namespace Modules\Education\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Education\Entities\Payment;

/** @mixin Payment */
class PaymentResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    return [
      'id' => $this->id,
      'sourceCashRegister' => $this->whenHas('sourceCashRegister', $this->sourceCashRegister),
      'destinationCashRegister' => $this->whenHas('destinationCashRegister', $this->destinationCashRegister),
      'staff' => $this->whenHas('staff', $this->staff),
      'currency' => $this->whenHas('currency', $this->currency),
      'customer' => $this->whenHas('customer', $this->customer),
      'payable' => $this->whenHas('payable', $this->payable),
      'memo' => $this->whenHas('memo', $this->memo),
      'amount' => $this->whenHas('amount', $this->amount),
      'paymentDate' => $this->whenHas('payment_date', $this->payment_date),


      'created_at' => $this->whenHas('created_at', $this->created_at),
      'updated_at' => $this->whenHas('updated_at', $this->updated_at),
    ];
  }
}
