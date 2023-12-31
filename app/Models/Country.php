<?php

namespace App\Models;

use App\Traits\Trackable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
  use HasFactory, Trackable;

  protected $guarded = [];

  protected $casts = [
    'timezones' => 'array',
    'translations' => 'array',
  ];

  public function cities(): HasMany
  {
    return $this->hasMany(City::class);
  }

  public function states(): HasMany
  {
    return $this->hasMany(State::class);
  }
}
