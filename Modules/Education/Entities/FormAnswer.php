<?php

namespace Modules\Education\Entities;

use App\Traits\Trackable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Education\Database\factories\FormAnswerFactory;

class FormAnswer extends Model
{
    use HasFactory , Trackable;

    protected $guarded = [];
    protected $casts = [
        'answer' => 'array',
    ];
    protected static function newFactory()
    {
        return FormAnswerFactory::new();
    }

    public function question () : BelongsTo
    {
        return $this->belongsTo(FormQuestion::class);
    }

    public function participator () : BelongsTo
    {
        return $this->belongsTo(Participator::class);
    }
    public function section () : BelongsTo
    {
        return $this->belongsTo(FormSection::class);
    }
}
