<?php

namespace Modules\Education\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Education\Database\factories\LevelFactory;

class Level extends Model
{
  use HasFactory;

  protected $guarded = [];

  protected static function newFactory()
  {
    return LevelFactory::new();
  }

  public function branch(): BelongsTo
  {
    return $this->belongsTo(Branch::class);
  }
}
