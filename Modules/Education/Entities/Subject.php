<?php

namespace Modules\Education\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Education\Database\factories\SubjectFactory;

class Subject extends Model
{

  use HasFactory;

  protected $guarded = [];

  protected static function newFactory()
  {
    return SubjectFactory::new();
  }
  public function unity(): BelongsTo
  {
    return $this->belongsTo(Unity::class);
  }

  public function classroomType(): BelongsTo
  {
    return $this->belongsTo(ClassroomType::class);
  }

  public function periods(): BelongsToMany
  {
    return $this->belongsToMany(Period::class, SubjectPeriod::class)->using(SubjectPeriod::class);
  }
}
