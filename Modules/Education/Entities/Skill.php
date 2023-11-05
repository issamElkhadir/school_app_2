<?php

namespace Modules\Education\Entities;

use App\Traits\Trackable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Education\Database\factories\SkillFactory;

class Skill extends Model
{
  use Trackable, HasFactory;

  protected $guarded = [];
  protected $table = "skills";

  protected static function newFactory()
  {
    return SkillFactory::new();
  }

  public function staff(): BelongsTo
  {
    return $this->belongsTo(Staff::class);
  }

  public function subject(): BelongsTo
  {
    return $this->belongsTo(Subject::class);
  }

  public function level(): BelongsTo
  {
    return $this->belongsTo(Level::class);
  }

}
