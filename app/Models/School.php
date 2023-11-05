<?php

namespace App\Models;

use App\Traits\Trackable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Accounting\Entities\CashRegister;
use Modules\Education\Entities\Classroom;

class School extends Model
{
  use HasFactory, Trackable;

  protected $guarded = [];

  public function cashRegisters(): MorphMany
  {
    return $this->morphMany(CashRegister::class, 'owner');
  }

  public function city(): BelongsTo
  {
    return $this->belongsTo(City::class, 'contact_city_id');
  }

  public function country(): BelongsTo
  {
    return $this->belongsTo(Country::class, 'contact_country_id');
  }

  public function classrooms(): HasMany
  {
    return $this->hasMany(Classroom::class, 'school_id');
  }
}
