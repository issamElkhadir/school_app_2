<?php

namespace Modules\Education\Entities;

use App\Models\School;
use App\Traits\Trackable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Education\Database\factories\SanctionTypeFactory;

class SanctionType extends Model
{
    use HasFactory,Trackable;

    protected $guarded = [];

    protected static function newFactory()
    {
        return SanctionTypeFactory::new();
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function sanction(): HasMany
    {
      return $this->hasMany(Sanction::class);
    }

}
