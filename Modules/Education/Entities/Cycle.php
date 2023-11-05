<?php

namespace Modules\Education\Entities;

use App\Models\School;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Education\Database\factories\CycleFactory;

class Cycle extends Model
{
  use HasFactory;

  protected $guarded = [];

  protected static function newFactory()
  {
    return CycleFactory::new();
  }

  public function schools(): BelongsToMany
  {
    return $this->belongsToMany(School::class, CycleSchool::class)
      ->using(CycleSchool::class);
  }

  public function branches(): HasMany
  {
    return $this->hasMany(Branch::class);
  }
}
