<?php

namespace Modules\Education\Transformers;

use App\Http\Resources\MeasureUnitResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Education\Entities\PaymentSchedule;

/** @mixin PaymentSchedule */
class PaymentScheduleResource extends JsonResource
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
      'amount_to_pay' => $this->whenHas('amount_to_pay', $this->amount_to_pay),
      'amount_paid' => $this->whenHas('amount_paid', $this->amount_paid),
      'payment_date' => $this->whenHas('payment_date', $this->payment_date),
      'payment_bill' => new PaymentBillResource($this->whenLoaded('paymentBill')),
      'invoicing_policy' => $this->whenHas('invoicing_policy', $this->invoicing_policy),


      'created_at' => $this->whenHas('created_at', $this->created_at),
      'updated_at' => $this->whenHas('updated_at', $this->updated_at),

    ];
  }
}
