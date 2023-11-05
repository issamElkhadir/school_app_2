<?php

namespace Modules\Education\Entities;

use App\Models\School;
use App\Models\User;
use App\Traits\Trackable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Education\Database\factories\StudentAuthorizationRequestFactory;

class StudentAuthorizationRequest extends Model
{
    use HasFactory, Trackable;

    protected $guarded = [];

    protected static function newFactory()
    {
        return StudentAuthorizationRequestFactory::new();
    }
    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }
    public function unity(): BelongsTo
    {
        return $this->belongsTo(Unity::class);
    }
    public function authorizedBy(): BelongsTo
    {
        return $this->belongsTo(User::class,'authorized_by','id');
    }
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
}
