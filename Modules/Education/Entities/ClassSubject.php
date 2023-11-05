<?php

namespace Modules\Education\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ClassSubject extends Pivot
{
//  use HasFactory;

  protected $guarded = [];

  protected $table = "class_subjects";

//  protected static function newFactory()
//  {
//    return \Modules\Education\Database\factories\ClassSubjectFactory::new();
//  }
}
