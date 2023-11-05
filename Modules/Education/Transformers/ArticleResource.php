<?php

namespace Modules\Education\Transformers;

use App\Http\Resources\CurrencyResource;
use App\Http\Resources\MeasureUnitResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Education\Entities\Article;

/** @mixin Article */
class ArticleResource extends JsonResource
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
      'item_type' => 'education.article',
      'rtl_name' => $this->whenHas('rtl_name', $this->rtl_name),
      'currency' => CurrencyResource::make($this->whenLoaded('currency')),
      'unit' => MeasureUnitResource::make($this->whenLoaded('unit')),
      'category' => CategoryResource::make($this->whenLoaded('category')),
      'product_type' => $this->whenHas('product_type', $this->product_type),
      'invoicing_policy' => $this->whenHas('invoicing_policy', $this->invoicing_policy),
      'sale_price' => $this->whenHas('sale_price', $this->sale_price),
      'vat' => $this->whenHas('vat', $this->vat),
      'default_code' => $this->whenHas('default_code', $this->default_code),
      'barcode' => $this->whenHas('barcode', $this->barcode),
      'paymentBills' => PaymentBillResource::collection($this->whenLoaded('paymentBills')),
    ];
  }
}
