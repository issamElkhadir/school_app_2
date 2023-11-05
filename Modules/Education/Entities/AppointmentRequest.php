<?php

namespace Modules\Education\Entities;

use App\Models\School;
use App\Traits\Trackable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Education\Database\factories\AppointmentRequestFactory;

class AppointmentRequest extends Model
{
    use HasFactory, Trackable;

    protected $guarded = [];

    protected static function newFactory()
    {
        return AppointmentRequestFactory::new();
    }

    public function school ():BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function staff ():BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }

    public function student ():BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
    public function guardian ():BelongsTo
    {
        return $this->belongsTo(Guardian::class);
    }
}
