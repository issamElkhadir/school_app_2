<?php

namespace Modules\Education\Entities;

use App\Traits\Trackable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Education\Database\factories\FormFactory;

class Form extends Model
{
    use HasFactory , Trackable;

    protected $guarded = [];
    protected $casts = [
        'preferences' => 'array',
    ];
    protected static function newFactory()
    {
        return FormFactory::new();
    }
    public function sections() : HasMany
    {
        return $this->hasMany(FormSection::class, 'form_id')->orderBy('order');
    }
}
