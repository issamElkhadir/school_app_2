<?php

namespace Modules\Education\Entities;

use App\Models\School;
use App\Traits\Trackable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Education\Database\factories\VacationTypeFactory;

class VacationType extends Model
{
  use HasFactory, Trackable;
  protected $guarded = [];

  protected static function newFactory()
  {
    return VacationTypeFactory::new();
  }
  public function school(): BelongsTo
  {
    return $this->belongsTo(School::class, 'school_id');
  }
  public function vacation(): HasMany
  {
    return $this->hasMany(Vacation::class);
  }
}
