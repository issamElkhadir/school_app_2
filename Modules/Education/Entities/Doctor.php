<?php

namespace Modules\Education\Entities;

use App\Models\School;
use App\Traits\Trackable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Education\Database\factories\DoctorFactory;

class Doctor extends Model
{
  use HasFactory, Trackable;

  protected $guarded = [];
  protected static function newFactory()
  {
    return DoctorFactory::new();
  }

  public function school(): BelongsTo
  {
    return $this->belongsTo(School::class);
  }


}
