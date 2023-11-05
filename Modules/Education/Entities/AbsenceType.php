<?php

namespace Modules\Education\Entities;

use App\Traits\Trackable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Education\Database\factories\AbsenceTypeFactory;

class AbsenceType extends Model
{
  use HasFactory, Trackable;

  protected $guarded = [];

  protected static function newFactory()
  {
    return AbsenceTypeFactory::new();
  }
}
