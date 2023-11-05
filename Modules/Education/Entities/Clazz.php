<?php

namespace Modules\Education\Entities;

use App\Models\School;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Education\Database\factories\ClassFactory;

class Clazz extends Model
{
  use HasFactory;

  protected $guarded = [];

  protected $table = 'classes';

    protected static function newFactory()
    {
        return ClassFactory::new();
    }

  public function school(): BelongsTo
  {
    return $this->belongsTo(School::class);
  }

  public function level(): BelongsTo
  {
    return $this->belongsTo(Level::class);
  }

  public function parentClass(): BelongsTo
  {
    return $this->belongsTo(Clazz::class, 'class_id');
  }

  public function subjects(): BelongsToMany
  {
    return $this->belongsToMany(Subject::class, ClassSubject::class, 'class_id', 'subject_id')->using(ClassSubject::class);
  }
}
