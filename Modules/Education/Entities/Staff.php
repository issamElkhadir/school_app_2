<?php

namespace Modules\Education\Entities;

use App\Models\Profilable;
use App\Models\School;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Modules\Accounting\Entities\CashRegister;
use Modules\Education\Database\factories\StaffFactory;

class Staff extends Model implements Profilable
{
  use HasFactory;

  protected $guarded = [];

  protected static function newFactory()
  {
    return StaffFactory::new();
  }

  public function user(): MorphOne
  {
    return $this->morphOne(User::class, 'profile');
  }

  public function schools(): BelongsToMany
  {
    return $this->belongsToMany(School::class, SchoolStaff::class)
      ->using(SchoolStaff::class);
  }

  public function assignedCashRegisters(): BelongsToMany
  {
    return $this->belongsToMany(CashRegister::class, 'staff_cash_registers');
  }


  public function skills(): HasMany
  {
    return $this->hasMany(Skill::class);
  }

  public function toArray(): array
  {
    return [
      'id' => $this->id,
      'name' => $this->name,
      'email' => $this->email,
      'phone' => $this->phone,
      'address' => $this->address,
      'salary' => $this->salary,
      'week_hours' => $this->week_hours,
//      'type' => 'staff'
    ];
  }

  public function createdBy()
  {
    return $this->belongsTo(User::class, 'created_by');
  }
}
