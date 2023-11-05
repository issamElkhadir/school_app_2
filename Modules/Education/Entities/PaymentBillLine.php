<?php

namespace Modules\Education\Entities;

use App\Modules\Base\Models\MeasureUnit;
use App\Modules\Base\Models\Traits\HasFiscalYear;
use App\Modules\Base\Models\Traits\Trackable;
use App\Modules\Base\Models\Traits\HasSchema;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentBillLine extends Model
{
  use HasFactory;

  protected $guarded = [];

  protected static function newFactory()
  {
    return \Modules\Education\Database\factories\PaymentBillLineFactory::new();
  }

    protected $casts = [
        'quantity' => 'float',
        'price_unit' => 'float',
        'vat' => 'float',
        'subtotal' => 'float',
    ];

    public function paymentBill(): BelongsTo
    {
        return $this->belongsTo(PaymentBill::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(\App\Models\MeasureUnit::class);
    }

    public function item(): BelongsTo
    {
        return $this->morphTo('item');
    }
}
