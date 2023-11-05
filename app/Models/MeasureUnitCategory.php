<?php

namespace App\Models;

use App\Traits\Trackable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeasureUnitCategory extends Model
{
  use HasFactory, Trackable;

  protected $guarded = [];

  public function units()
  {
    return $this->hasMany(MeasureUnit::class, 'measure_unit_category_id');
  }
}
