<?php

namespace Modules\Education\Entities;

use App\Models\School;
use App\Traits\Trackable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Allergy extends Model
{
    use HasFactory,Trackable;

    protected $guarded = [];
    
    protected static function newFactory()
    {
        return \Modules\Education\Database\factories\AllergyFactory::new();
    }
    public function school(): BelongsTo
  {
    return $this->belongsTo(School::class);
  }
  public function allergyType(): BelongsTo
  {
    return $this->belongsTo(AllergyType::class);
  }
}
