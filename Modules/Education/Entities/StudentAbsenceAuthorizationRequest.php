<?php

namespace Modules\Education\Entities;

use App\Models\School;
use App\Models\User;
use App\Traits\Trackable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Education\Database\factories\StudentAbsenceAuthorizationRequestFactory;

class StudentAbsenceAuthorizationRequest extends Model
{
    use HasFactory, Trackable;

    protected $guarded = [];

    protected static function newFactory()
    {
        return StudentAbsenceAuthorizationRequestFactory::new();
    }
    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }
    public function acceptedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'accepted_by', 'id');
    }
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
}
