<?php

namespace Modules\Education\Entities;

use App\Models\School;
use App\Traits\Trackable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Achievement extends Model
{
    use HasFactory,Trackable;

    protected $guarded = [];
    
    protected static function newFactory()
    {
        return \Modules\Education\Database\factories\AchievementFactory::new();
    }

    public function class() : BelongsTo
    {
        return $this->belongsTo(Clazz::class);
    }

    public function achievementType() : BelongsTo
    {
        return $this->belongsTo(AchievementType::class);
    }

    public function school() : BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function achievable(): MorphTo
  {
    return $this->morphTo('achievable');
  }
}
