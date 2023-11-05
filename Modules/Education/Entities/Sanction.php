<?php

namespace Modules\Education\Entities;

use App\Traits\Trackable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Education\Database\factories\SanctionFactory;

class Sanction extends Model
{
    use HasFactory,Trackable;

    protected $guarded = [];

    protected static function newFactory()
    {
        return SanctionFactory::new();
    }

    public function sanctionType(): BelongsTo
    {
      return $this->belongsTo(SanctionType::class);
    }
    public function staff(): BelongsTo
    {
      return $this->belongsTo(Staff::class);
    }
}
