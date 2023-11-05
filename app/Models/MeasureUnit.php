<?php

namespace App\Models;

use App\Models\Enums\MeasureUnitType;
use App\Traits\Trackable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MeasureUnit extends Model
{
  use HasFactory, Trackable;

  protected $guarded = [];

  protected $casts = [
    'type' => MeasureUnitType::class,
  ];

  public function category(): BelongsTo
  {
    return $this->belongsTo(MeasureUnitCategory::class, 'measure_unit_category_id');
  }
}
