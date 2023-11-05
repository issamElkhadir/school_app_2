<?php

namespace Modules\Education\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Education\Database\factories\UnityFactory;

class Unity extends Model
{
  use HasFactory;

  protected $guarded = [];

  protected static function newFactory()
  {
    return UnityFactory::new();
  }

  public function subjects(): HasMany
  {
    return $this->hasMany(Subject::class, 'unity_id');
  }
}
