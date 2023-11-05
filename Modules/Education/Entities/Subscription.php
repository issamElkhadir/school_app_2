<?php

namespace Modules\Education\Entities;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Subscription extends Model
{
  use HasFactory;

  protected $guarded = [];

  protected static function newFactory()
  {
    return \Modules\Education\Database\factories\SubscriptionFactory::new();
  }

  protected static ?int $examId = null;

  protected $with = ['student'];


  public function student(): BelongsTo
  {
    return $this->belongsTo(Student::class);
  }

  public function class(): BelongsTo
  {
    return $this->belongsTo(Clazz::class);
  }

  public function paymentBill(): HasOne
  {
    return $this->hasOne(PaymentBill::class);
  }

  /*public function studentAuthorizationRequests(): HasMany
  {
    return $this->hasMany(StudentAuthorizationRequest::class);
  }*/

  /*public function absences(): HasMany
  {
    return $this->hasMany(Absence::class);
  }*/


  /*public function observations(): HasMany
  {
    return $this->hasMany(Observation::class);
  }*/

  /*public function achievementAbsence(): HasOne
  {
    return $this->hasOne(Absence::class)->with('absenceType:id,name');
  }*/

  /*public function achievementObservation(): HasOne
  {
    return $this->hasOne(Observation::class);
  }*/

  public function name(): Attribute
  {
    return Attribute::get(fn() => $this->student->first_name . ' ' . $this->student->last_name);
  }

  /*public function studentExamResults(): HasMany
  {
    return $this->hasMany(StudentExamResult::class, 'subscription_id');
  }*/

  /*public function studentExamResult(): HasOne
  {
    return $this->hasOne(StudentExamResult::class, 'subscription_id')
      ->when(isset(self::$examId), fn($query) => $query->where('exam_id', self::$examId))
      ->withDefault(new \stdClass());
  }*/

  /*public static function forExam(int $examId): self
  {
    self::$examId = $examId;

    return new self();
  }*/
}
