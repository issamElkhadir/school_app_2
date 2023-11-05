<?php

namespace Modules\Education\Entities;

use App\Traits\Trackable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Disease extends Model
{
  use HasFactory, Trackable;

  protected $guarded = [];

  protected static function newFactory()
  {
    return \Modules\Education\Database\factories\DiseaseFactory::new();
  }

  public function school(): BelongsTo
  {
    return $this->belongsTo(\App\Models\School::class);
  }
}
