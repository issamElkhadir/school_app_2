<?php

namespace Modules\Education\Entities;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CycleSchool extends Pivot
{

  protected $guarded = [];

  protected $table = "cycle_schools";
}
