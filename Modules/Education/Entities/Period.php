<?php

namespace Modules\Education\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Education\Database\factories\PeriodFactory;

class Period extends Model
{
  use HasFactory;

  protected $guarded = [];

  protected static function newFactory()
  {
    return PeriodFactory::new();
  }

  protected $casts = [
    'start_date' => 'date:Y-m-d',
    'end_date' => 'date:Y-m-d'
  ];
}
