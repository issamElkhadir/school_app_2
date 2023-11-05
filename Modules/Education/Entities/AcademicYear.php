<?php

namespace Modules\Education\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Education\Database\factories\AcademicYearFactory;

class AcademicYear extends Model
{
  use HasFactory;

  protected $table = "academic_years";

  protected $guarded = [];

  protected static function newFactory()
  {
    return AcademicYearFactory::new();
  }

  protected $casts = [
    'start_date' => 'date',
    'end_date' => 'date',
    'status' => 'boolean',
    'is-locked' => 'boolean'
  ];

  public function parentAcademicYear(): BelongsTo
  {
    return $this->belongsTo(AcademicYear::class, 'parent_academic_year_id');
  }

}
