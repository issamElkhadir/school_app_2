<?php

namespace App\Models;

use App\Traits\Trackable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class State extends Model
{
  use HasFactory, Trackable;

  protected $guarded = [];

  public function cities(): HasMany
  {
    return $this->hasMany(City::class);
  }

  public function country(): BelongsTo
  {
    return $this->belongsTo(Country::class);
  }
}
