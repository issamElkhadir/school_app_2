<?php

namespace Modules\Education\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Education\Entities\Subscription;

/** @mixin Subscription */
class SubscriptionResource extends JsonResource
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
      'principal'=> $this->whenHas('principal', $this->principal),
      'subscription_date' => $this->whenHas('subscription_date', $this->subscription_date),
      'sequence' => $this->whenHas('sequence', $this->sequence),
      'student' => new StudentResource($this->whenLoaded('student')),
      'class' => new ClassResource($this->whenLoaded('class')),
      'paymentBill' => new PaymentBillResource($this->whenLoaded('paymentBill')),

      'created_at' => $this->whenHas('created_at', $this->created_at),
      'updated_at' => $this->whenHas('updated_at', $this->updated_at),
    ];
  }
}
