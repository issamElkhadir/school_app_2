<?php

namespace Modules\Education\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Education\Database\factories\ClassroomTypeFactory;

class ClassroomType extends Model
{
  use HasFactory;

  protected $guarded = [];

  protected static function newFactory()
  {
    return ClassroomTypeFactory::new();
  }
}
