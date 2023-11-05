<?php

namespace Modules\Accounting\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Accounting\Entities\CashRegister;

/** @mixin CashRegister */
class CashRegisterResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    return [
      'id' => $this->whenHas('id'),
      'name' => $this->whenHas('name'),
      'rtl_name' => $this->whenHas('rtl_name'),
      'is_real' => $this->whenHas('is_real'),
      'status' => $this->whenHas('status'),
      'initial_balance' => $this->whenHas('initial_balance'),
      'owner' => $this->owner,
      'created_at' => $this->whenHas('created_at'),
      'updated_at' => $this->whenHas('updated_at'),
    ];
  }
}
