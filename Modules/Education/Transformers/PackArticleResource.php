<?php

namespace Modules\Education\Transformers;

use App\Http\Resources\CurrencyResource;
use App\Http\Resources\MeasureUnitResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Education\Entities\Article;
use Modules\Education\Entities\PackArticle;

/** @mixin PackArticle */
class PackArticleResource extends JsonResource
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
      'article' => ArticleResource::make($this->whenLoaded('article')),
      'pack' => PackResource::make($this->whenLoaded('pack')),
      'currency' => CurrencyResource::make($this->whenLoaded('currency')),
      'sale_price' => $this->whenHas('sale_price', $this->sale_price),
      'discount' => $this->whenHas('discount', $this->discount),
      'vat' => $this->whenHas('vat', $this->vat),
    ];
  }
}
