<?php

namespace Modules\Education\Entities;

use App\Models\MeasureUnit;
use App\Traits\Trackable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Education\Database\factories\PackFactory;
use Modules\Education\Entities\Enum\InvoicingPolicy;

class Pack extends Model
{
  use HasFactory, Trackable;

  protected $guarded = [];

  protected static function newFactory()
  {
    return PackFactory::new();
  }

  protected $casts = [
    'invoicing_policy' => InvoicingPolicy::class,

    'sale_price' => 'float'
  ];

  public function level(): BelongsTo
  {
    return $this->belongsTo(Level::class);
  }

  public function articles(): HasMany
  {
    return $this->hasMany(PackArticle::class);
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
