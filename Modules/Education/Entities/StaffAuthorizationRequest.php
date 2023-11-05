<?php

namespace Modules\Education\Entities;

use App\Models\School;
use App\Models\User;
use App\Traits\Trackable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Education\Database\factories\StaffAuthorizationRequestFactory;

class StaffAuthorizationRequest extends Model
{
    use HasFactory, Trackable;

    protected $guarded = [];

    protected static function newFactory()
    {
        return StaffAuthorizationRequestFactory::new();
    }
    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }
    public function responsible(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsible_id', 'id');
    }
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
}
