<?php

namespace Modules\Education\Entities;

use App\Traits\Trackable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Education\Database\factories\FormQuestionFactory;

class FormQuestion extends Model
{
    use HasFactory , Trackable;

    protected $guarded = [];
    protected $casts = [
        'options' => 'array',
    ];
    protected static function newFactory()
    {
        return FormQuestionFactory::new();
    }
    public function section() :BelongsTo
    {
        return $this->belongsTo(FormSection::class, 'section_id');
    }
}
