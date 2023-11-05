<?php

namespace Modules\Education\Entities;

use App\Models\Currency;
use App\Models\MeasureUnit;
use App\Traits\Trackable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Article extends Model
{
  use HasFactory, Trackable;

  protected $guarded = [];

  protected static function newFactory()
  {
    return \Modules\Education\Database\factories\ArticleFactory::new();
  }

  protected $table = "articles";

  protected $casts = [
    'invoicing_policy' => \Modules\Education\Entities\Enum\InvoicingPolicy::class,
    'product_type' => \Modules\Education\Entities\Enum\ProductType::class
  ];

  public function packs(): BelongsToMany
  {
    return $this->belongsToMany(Pack::class, PackArticle::class)->using(PackArticle::class);
  }

  public function category(): BelongsTo
  {
    return $this->belongsTo(Category::class);
  }

  public function currency(): BelongsTo
  {
    return $this->belongsTo(Currency::class);
  }

  public function unit(): BelongsTo
  {
    return $this->belongsTo(MeasureUnit::class, 'unit_id');
  }

  public function paymentBills(): MorphMany
  {
    return $this->morphMany(PaymentBill::class, 'item', 'type', 'item_id');
  }

}
