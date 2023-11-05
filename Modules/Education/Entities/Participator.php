<?php

namespace Modules\Education\Entities;

use App\Traits\Trackable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Education\Database\factories\ParticipatorFactory;

class Participator extends Model
{
    use HasFactory , Trackable;

    protected $guarded = [];
    
    protected static function newFactory()
    {
        return ParticipatorFactory::new();
    }

    public function form () : BelongsTo
    {
        return $this->belongsTo(Form::class);
    }

    public function student () : BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
    
}
