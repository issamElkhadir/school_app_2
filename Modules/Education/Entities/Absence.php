<?php

namespace Modules\Education\Entities;

use App\Traits\Trackable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Education\Database\factories\AbsenceFactory;

class Absence extends Model
{
    use HasFactory , Trackable;

    protected $guarded = [];
    
    protected static function newFactory()
    {
        return AbsenceFactory::new();
    }

    public function absence_type () : BelongsTo
    {
        return $this->belongsTo(AbsenceType::class);
    }

    public function student () : BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function achievement () :BelongsTo
    {
        return $this->belongsTo(Achievement::class);
    }
    public function subscription () : BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }
}
