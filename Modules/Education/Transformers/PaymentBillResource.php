<?php

namespace Modules\Education\Transformers;

use App\Http\Resources\CurrencyResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Education\Entities\PaymentBill;

/** @mixin PaymentBill */
class PaymentBillResource extends JsonResource
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
      'sequence' => $this->whenHas('sequence', $this->sequence),
      'subscription' => new SubscriptionResource($this->whenLoaded('subscription')),
      'untaxed_amount' => $this->whenHas('untaxed_amount', $this->untaxed_amount),
      'tax_amount' => $this->whenHas('tax_amount', $this->tax_amount),
      'total_amount' => $this->whenHas('total_amount', $this->total_amount),
      'paid_amount' => $this->whenHas('paid_amount', $this->paid_amount),
      'unpaid_amount' => $this->whenHas('unpaid_amount', $this->unpaid_amount),
      'currency' => new CurrencyResource($this->whenLoaded('currency')),
      'lines' => PaymentBillLineResource::collection($this->whenLoaded('lines')),

    ];
  }
}
