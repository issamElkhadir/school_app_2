<?php

namespace App\Models;

use App\Traits\Trackable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sequence extends Model
{
  use HasFactory, Trackable;

  protected $guarded = [];

  public function school(): BelongsTo
  {
    return $this->belongsTo(School::class);
  }
}
