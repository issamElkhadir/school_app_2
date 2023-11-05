<?php

namespace Modules\Education\Entities;
use Illuminate\Database\Eloquent\Relations\Pivot;

class SubjectPeriod extends Pivot
{
  protected $guarded = [];

  protected $table = "subject_periods";
}
