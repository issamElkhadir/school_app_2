<?php

namespace Modules\Education\Entities;

use App\Traits\Trackable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Education\Database\factories\FormSectionFactory;

class FormSection extends Model
{
    use HasFactory , Trackable;

    protected $guarded = [];
    
    protected static function newFactory()
    {
        return FormSectionFactory::new();
    }
    public function form() :BelongsTo
    {
        return $this->belongsTo(Form::class, 'form_id');
    }

    public function questions() :HasMany
    {
        return $this->hasMany(FormQuestion::class, 'section_id')->orderBy('order');
    }
}
