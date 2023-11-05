<?php

namespace Modules\Education\Entities;

use App\Traits\Trackable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Education\Database\factories\ScheduleFactory;

class Schedule extends Model
{
  use HasFactory, Trackable;

  protected $guarded = [];

  protected static function newFactory()
  {
    return ScheduleFactory::new();
  }

  public function class(): BelongsTo
  {
    return $this->belongsTo(Clazz::class);
  }

  public function level(): BelongsTo
  {
    return $this->belongsTo(Level::class);
  }

  public function branch(): BelongsTo
  {
    return $this->belongsTo(Branch::class);
  }

  public function sessions() : HasMany
  {
    return $this->hasMany(Session::class);
  }

}
