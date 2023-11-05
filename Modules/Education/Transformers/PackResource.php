<?php

namespace Modules\Education\Transformers;

use App\Http\Resources\MeasureUnitResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Education\Entities\Pack;

/** @mixin Pack */
class PackResource extends JsonResource
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
      'rtl_name' => $this->whenHas('rtl_name', $this->rtl_name),
      'item_type' => 'education.pack',
      'unit' => MeasureUnitResource::make( $this->whenLoaded('unit')),
      'level' => LevelResource::make( $this->whenLoaded('level')),
      'articles' => PackArticleResource::collection( $this->whenLoaded('articles')),
      'invoicing_policy' => $this->whenHas('invoicing_policy', $this->invoicing_policy),
      'sale_price' => $this->whenHas('sale_price', $this->sale_price),
      'vat' => $this->whenHas('vat', $this->vat),
      'status' => $this->whenHas('status', $this->status),
      'description' => $this->whenHas('description', $this->description),
      'short_name' => $this->whenHas('short_name', $this->short_name),
      'paymentBills' => PaymentBillResource::collection($this->whenLoaded('paymentBills')),

    ];
  }
}
