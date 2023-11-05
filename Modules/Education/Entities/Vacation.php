<?php

namespace Modules\Education\Entities;

use App\Traits\Trackable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Education\Database\factories\VacationFactory;

class Vacation extends Model
{
    use HasFactory , Trackable;
    protected $guarded = [];

    protected static function newFactory()
    {
        return VacationFactory::new();
    }

    public function vacationType(): BelongsTo
    {
      return $this->belongsTo(VacationType::class);
    }
    public function staff(): BelongsTo
    {
      return $this->belongsTo(Staff::class);
    }
}
