<?php

namespace Modules\Education\Entities;

use App\Models\School;
use App\Traits\Trackable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Education\Database\factories\PreInscriptionsFactory;

class PreInscription extends Model
{
    use HasFactory , Trackable;

    protected $guarded = [];

    
    protected static function newFactory()
    {
        return PreInscriptionsFactory::new();
    }

    public function school () : BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function form () : BelongsTo
    {
        return $this->belongsTo(Form::class);
    }

    public function level () : BelongsTo
    {
        return $this->belongsTo(Level::class);
    }
}
