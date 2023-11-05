<?php

namespace Modules\Education\Entities;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentBill extends Model
{
  use HasFactory;

  protected $guarded = [];

  protected static function newFactory()
  {
    return \Modules\Education\Database\factories\PaymentBillFactory::new();
  }

  protected $casts = [
    'untaxed_amount' => 'double',
    'total_amount' => 'double',
    'tax_amount' => 'double',
    'unpaid_amount' => 'double',
    'paid_amount' => 'double',
  ];


  public function lines(): HasMany
  {
    return $this->hasMany(PaymentBillLine::class, 'payment_bill_id');
  }

  public function subscription(): BelongsTo
  {
    return $this->belongsTo(Subscription::class);
  }

  public function paymentSchedules(): HasMany
  {
    return $this->hasMany(PaymentSchedule::class, 'payment_bill_id');
  }

  public function currency(): BelongsTo
  {
    return $this->belongsTo(Currency::class);
  }
}
