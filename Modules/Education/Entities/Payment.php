<?php

namespace Modules\Education\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\Accounting\Entities\CashRegister;
use Modules\Education\Entities\Enum\PaymentMethod;

class Payment extends Model
{
  use HasFactory;

  protected $guarded = [];

  protected static function newFactory()
  {
    return \Modules\Education\Database\factories\PaymentFactory::new();
  }

  protected $casts = [
    'payment_method' => PaymentMethod::class,
  ];

  public function sourceCashRegister(): BelongsTo
  {
    return $this->belongsTo(CashRegister::class, 'source_cash_register_id');
  }

  public function destinationCashRegister(): BelongsTo
  {
    return $this->belongsTo(CashRegister::class, 'destination_cash_register_id');
  }

  public function staff(): BelongsTo
  {
    return $this->belongsTo(Staff::class);
  }

  public function customer(): MorphTo
  {
    return $this->morphTo('customer');
  }

  public function payable(): MorphTo
  {
    return $this->morphTo('payable');
  }

  public function currency(): BelongsTo
  {
    return $this->belongsTo(\App\Models\Currency::class);
  }
}
