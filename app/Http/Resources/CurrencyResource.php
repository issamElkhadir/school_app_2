<?php

namespace App\Http\Resources;

use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Currency */
class CurrencyResource extends JsonResource
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
      'name' => $this->whenHas('name', $this->name),
      'code' => $this->whenHas('code', $this->code),
      'symbol' => $this->whenHas('symbol', $this->symbol),
      'is_active' => $this->whenHas('is_active', $this->is_active),
      'symbol_native' => $this->whenHas('symbol_native', $this->symbol_native),
      'decimal_digits' => $this->whenHas('decimal_digits', $this->decimal_digits),
      'rounding' => $this->whenHas('rounding', $this->rounding),
      'name_plural' => $this->whenHas('name_plural', $this->name_plural),
    ];
  }
}
