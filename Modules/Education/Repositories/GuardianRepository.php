<?php

namespace Modules\Education\Repositories;

use App\Repositories\BaseRepository;
use Modules\Education\Entities\Guardian;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * @template T of \Modules\Education\Entities\Guardian
 */
class GuardianRepository extends BaseRepository
{
  public function create(array $attributes)
  {
    $attributes['city_id'] = $attributes['city']['id'];
    $attributes['country_id'] = $attributes['country']['id'];

    unset($attributes['city'], $attributes['country']);

    return parent::create($attributes);
  }

  public function update($model, array $attributes)
  {
    $attributes['city_id'] = $attributes['city']['id'];
    $attributes['country_id'] = $attributes['country']['id'];

    unset($attributes['city'], $attributes['country']);

    return parent::update($model, $attributes);
  }

  public function model()
  {
    return Guardian::class;
  }

  public function allowedIncludes(): array
  {
    return ['city', 'country'];
  }

  public function allowedFields(): array
  {
    return [
      "id",
      "city_id",
      "country_id",
      "cities.id",
      "cities.name",
      "countries.id",
      "countries.name",
      "first_name",
      "last_name",
      "rtl_first_name",
      "rtl_last_name",
      "cni_number",
      "home_phone",
      "mobile_phone",
      "email_address",
      "created_at",
      "updated_at",
    ];
  }


  public function allowedSorts(): array
  {
    return [
      'id',
      'first_name',
      'last_name',
      'cni_number',
      'home_phone',
    ];
  }

  public function allowedFilters(): array
  {
    return [
      AllowedFilter::exact('id'),
      AllowedFilter::partial('first_name'),
      AllowedFilter::partial('last_name'),
      AllowedFilter::partial('home_phone'),
      AllowedFilter::exact('city.id', 'city_id'),
    ];
  }

  public function searchFields(): array
  {
    return [
      'id',
      'first_name',
    ];
  }

  public function defaultIncludes(): array
  {
    return ['city:id,name', 'country:id,name'];
  }

}
