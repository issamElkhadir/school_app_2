<?php

namespace Modules\Education\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Education\Database\factories\SubjectSequenceFactory;

class SubjectSequence extends Model
{
  use HasFactory;

  protected $guarded = [];

  protected static function newFactory()
  {
    return SubjectSequenceFactory::new();
  }

  protected $table = "subject_sequences";

  public function subject(): BelongsTo
  {
    return $this->belongsTo(Subject::class);
  }
}
