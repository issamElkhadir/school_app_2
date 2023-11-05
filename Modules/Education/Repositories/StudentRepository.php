<?php

namespace Modules\Education\Repositories;

use App\Filters\BooleanFilter;
use App\Repositories\BaseRepository;
use Modules\Education\Entities\Student;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * @template T of \Modules\Education\Entities\Student
 */
class StudentRepository extends BaseRepository
{
  public function create(array $attributes)
  {
    $attributes['contact_country_id'] = $attributes['country']['id'];
    $attributes['contact_city_id'] = $attributes['city']['id'];
    $attributes['native_language'] = $attributes['nativeLanguage']['id'];
    $attributes['second_language'] = $attributes['secondLanguage']['id'];
    $attributes['nationality_id'] = $attributes['nationality']['id'];
    $attributes['birth_city_id'] = $attributes['birthCity']['id'];

    unset($attributes['city'], $attributes['country'], $attributes['secondLanguage'], $attributes['nativeLanguage'], $attributes['birthCity'], $attributes['nationality']);

    return parent::create($attributes);
  }

  public function update($model, array $attributes)
  {
    $attributes['contact_country_id'] = $attributes['country']['id'];
    $attributes['contact_city_id'] = $attributes['city']['id'];
    $attributes['native_language'] = $attributes['nativeLanguage']['id'];
    $attributes['second_language'] = $attributes['secondLanguage']['id'];
    $attributes['nationality_id'] = $attributes['nationality']['id'];
    $attributes['birth_city_id'] = $attributes['birthCity']['id'];


    unset($attributes['city'], $attributes['country'], $attributes['secondLanguage'], $attributes['nativeLanguage'], $attributes['birthCity'], $attributes['nationality']);

    return parent::update($model, $attributes);
  }

  public function model()
  {
    return Student::class;
  }

  public function allowedIncludes(): array
  {
    return ['city', 'country', 'second_language', 'native_language', 'birth_city', 'nationality'];
  }

  public function allowedFields(): array
  {
    return [
      "id",
      "first_name",
      "last_name",
      "contact_city_id",
      "contact_country_id",
      "cities.id",
      "cities.name",
      "countries.id",
      "countries.name",

      "rtl_first_name",
      "rtl_last_name",
      "gender",
      "birthday",
      "birth_city_id",
      "nationality_id",
      "native_language",
      "second_language",
      "language.id",
      "language.name",

      "cin",
      "cne",
      "quotation",
      "insurance_name",
      "insurance_number",
      "old_school",
      "old_academy",
      "old_delegation",
      "notes",
      "how_he_knew_the_school",
      "has_scholarship",
      "scholarship_holder",
      "contact_address",
      "contact_rtl_address",
      "contact_name",
      "contact_email",
      "contact_whatsapp",
      "contact_website",
      "contact_phone_1",
      "contact_phone_2",
      "contact_mobile_1",
      "contact_mobile_2",
      "contact_fax_1",
      "contact_fax_2",
      "contact_street",
      "contact_zip",


    ];
  }


  public function allowedSorts(): array
  {
    return [
      'id',
      'first_name',
      'last_name',
      'image',
      'gender',
      'cin',
      'cne',
      'birthday',
    ];
  }

  public function allowedFilters(): array
  {
    return [
      AllowedFilter::exact('id'),
      AllowedFilter::partial('first_name'),
      AllowedFilter::partial('last_name'),
      AllowedFilter::partial('cin'),
      AllowedFilter::partial('cne'),
      AllowedFilter::custom('gender', BooleanFilter::make()),
      AllowedFilter::exact('city.id', 'contact_city_id'),
      AllowedFilter::exact('country.id', 'contact_country_id'),
      AllowedFilter::exact('city.id', 'birth_city_id'),
      AllowedFilter::exact('country.id', 'nationality_id'),
      //      AllowedFilter::exact('language.id', 'native_language'),
      //      AllowedFilter::exact('language.id', 'second_language'),
    ];
  }

  public function searchFields(): array
  {
    return [
      'id',
      'name',
    ];
  }

  public function defaultIncludes(): array
  {
    return [
      'city:id,name',
      'country:id,name',
      'nativeLanguage:id,name',
      'secondLanguage:id,name',
      'birthCity:id,name',
      'nationality:id,name'
    ];
  }

}
