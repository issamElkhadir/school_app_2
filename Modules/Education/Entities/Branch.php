<?php

namespace Modules\Education\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Branch extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function newFactory()
    {
        return \Modules\Education\Database\factories\BranchFactory::new();
    }

  public function cycle(): BelongsTo
  {
    return $this->belongsTo(Cycle::class);
  }
}
