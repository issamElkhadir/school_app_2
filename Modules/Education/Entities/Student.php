<?php

namespace Modules\Education\Entities;

use App\Models\City;
use App\Models\Country;
use App\Models\Language;
use App\Models\Profilable;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Modules\Education\Database\factories\StudentFactory;

class Student extends Model implements Profilable
{

  use HasFactory;

  protected $guarded = [];

  protected static function newFactory()
  {
    return StudentFactory::new();
  }

  public function user(): MorphOne
  {
    return $this->morphOne(User::class, 'profile');
  }

  public function nativeLanguage(): BelongsTo
  {
    return $this->belongsTo(Language::class, 'native_language');
  }

  public function secondLanguage(): BelongsTo
  {
    return $this->belongsTo(Language::class, 'second_language');
  }

  public function city(): BelongsTo
  {
    return $this->belongsTo(City::class, 'contact_city_id');
  }

  public function birthCity(): BelongsTo
  {
    return $this->belongsTo(City::class, 'birth_city_id');
  }

  public function country(): BelongsTo
  {
    return $this->belongsTo(Country::class, 'contact_country_id');
  }

  public function nationality(): BelongsTo
  {
    return $this->belongsTo(Country::class, 'nationality_id');
  }

  public function toArray(): array
  {
    return [
      'id' => $this->id,
      'name' => $this->name(),
      'first_name' => $this->first_name,
      'last_name' => $this->last_name,
      'image' => $this->image,
      'rtl_first_name' => $this->rtl_first_name,
      'rtl_last_name' => $this->rtl_last_name,
      'gender' => $this->gender,
      'nationality_id' => $this->nationality(),
      'birth_city_id' => $this->birthCity(),
      'cin' => $this->cin,
      'cne' => $this->cne,
      'birthday' => $this->birthday,
      'native_language' => $this->nativeLanguage(),
      'second_language' => $this->secondLanguage(),

      'quotation' => $this->quotation,
      'insurance_name' => $this->insurance_name,
      'insurance_number' => $this->insurance_number,
      'old_school' => $this->old_school,
      'old_academy' => $this->old_academy,
      'old_delegation' => $this->old_delegation,
      'notes' => $this->notes,
      'how_he_knew_the_school' => $this->how_he_knew_the_school,
      'has_scholarship' => $this->has_scholarship,
      'scholarship_holder' => $this->scholarship_holder,

      'contact_address' => $this->contact_address,
      'contact_rtl_address' => $this->contact_rtl_address,
      'contact_name' => $this->contact_name,
      'contact_email' => $this->contact_email,
      'contact_whatsapp' => $this->contact_whatsapp,
      'contact_website' => $this->contact_website,
      'contact_phone_1' => $this->contact_phone_1,
      'contact_phone_2' => $this->contact_phone_2,
      'contact_mobile_1' => $this->contact_mobile_1,
      'contact_mobile_2' => $this->contact_mobile_2,
      'contact_fax_1' => $this->contact_fax_1,
      'contact_fax_2' => $this->contact_fax_2,
      'contact_country_id' => $this->country(),
      'contact_city_id' => $this->city(),
      'contact_street' => $this->contact_street,
      'contact_zip' => $this->contact_zip,



    ];
  }

  public function name():Attribute
  {
    return Attribute::get(fn() => $this->first_name . ' ' . $this->last_name);
  }

}
