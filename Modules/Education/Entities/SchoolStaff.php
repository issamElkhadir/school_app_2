<?php

namespace Modules\Education\Entities;

use Illuminate\Database\Eloquent\Relations\Pivot;

class SchoolStaff extends Pivot
{

    protected $guarded = [];

    protected $table = "school_staff";

  /**
   * Indicates if the IDs are auto-incrementing.
   *
   * @var bool
   */
    public $incrementing = false;
}
