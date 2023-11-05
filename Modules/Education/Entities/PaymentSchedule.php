<?php

namespace Modules\Education\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Education\Entities\Enum\InvoicingPolicy;

class PaymentSchedule extends Model
{
  use HasFactory;

  protected $guarded = [];

  protected static function newFactory()
  {
    return \Modules\Education\Database\factories\PaymentScheduleFactory::new();
  }

    protected $casts = [
        'invoicing_policy' => InvoicingPolicy::class
    ];

    public function paymentBill(): BelongsTo
    {
        return $this->belongsTo(PaymentBill::class);
    }
}
