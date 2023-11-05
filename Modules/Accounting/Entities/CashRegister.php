<?php

namespace Modules\Accounting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class CashRegister extends Model
{
  use HasFactory;

  protected $guarded = [];

  public function owner(): MorphTo
  {
    return $this->morphTo('owner', 'owner_type', 'owner_id');
  }

  protected static function newFactory()
  {
    return \Modules\Accounting\Database\factories\CashRegisterFactory::new();
  }
}
