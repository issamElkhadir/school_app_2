<?php

namespace Modules\Education\Entities;

use App\Traits\Trackable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Education\Database\factories\SessionFactory;

class Session extends Model
{
  use Trackable, HasFactory;

  protected $guarded = [];

  protected static function newFactory()
  {
    return SessionFactory::new();
  }

  public function schedule(): BelongsTo
  {
    return $this->belongsTo(Schedule::class);
  }

  public function classroom(): BelongsTo
  {
    return $this->belongsTo(Classroom::class);
  }

  public function subject(): BelongsTo
  {
    return $this->belongsTo(Subject::class);
  }

  public function staff(): BelongsTo
  {
    return $this->belongsTo(Staff::class);
  }

  public function achievements(): MorphMany
  {
    return $this->morphMany(Achievement::class, 'achievable');
  }
}
