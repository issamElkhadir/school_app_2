<?php

namespace Modules\Education\Entities;

use App\Models\City;
use App\Models\Country;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Education\Database\factories\GuardianFactory;

class Guardian extends Model
{

  use HasFactory;

  protected $guarded = [];

  protected static function newFactory()
  {
    return GuardianFactory::new();
  }

  public function city() : BelongsTo
  {
    return $this->belongsTo(City::class);
  }

  public function country() : BelongsTo
  {
    return $this->belongsTo(Country::class);
  }

  public function name():Attribute
  {
    return Attribute::get(fn() => $this->first_name . ' ' . $this->last_name);
  }

}
