<?php

namespace Modules\Education\Transformers;

use App\Http\Resources\CurrencyResource;
use App\Http\Resources\MeasureUnitResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Education\Entities\Article;
use Modules\Education\Entities\Pack;
use Modules\Education\Entities\PaymentBillLine;

/** @mixin PaymentBillLine */
class PaymentBillLineResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    $resource = match (get_class($this->item)) {
      Article::class => ['education/articles', ArticleResource::make($this)->toArray($request)],
      Pack::class => ['education/packs', PackResource::make($this)->toArray($request)],
      default => null
    };
    return [
      'id' => $this->id,
      'name' => $this->whenHas('name', $this->name),
      'resource' => $resource[0] ?? null,
      'item' => $resource[1] ?? null,
      'quantity' => $this->whenHas('quantity', $this->quantity),
      'price_unit' => $this->whenHas('price_unit', $this->price_unit),
      'vat' => $this->whenHas('vat', $this->vat),
      'subtotal' => $this->whenHas('subtotal', $this->subtotal),
      'unit' => new MeasureUnitResource($this->whenLoaded('unit')),
      'paymentBill' => new PaymentBillResource($this->whenLoaded('paymentBill')),


      'created_at' => $this->whenHas('created_at', $this->created_at),
      'updated_at' => $this->whenHas('updated_at', $this->updated_at),

    ];
  }
}
