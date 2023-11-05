<?php

namespace App\Repositories;

use App\Filters\BooleanFilter;
use App\Repositories\BaseRepository;
use App\Models\School;
use Modules\Education\Entities\Classroom;
use Modules\Education\Repositories\ClassroomRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;

/**
 * @template T of School
 */
class SchoolRepository extends BaseRepository
{

  public function __construct(protected ClassroomRepository $classroomRepository)
  {
    parent::__construct();
  }

  public function create(array $attributes)
  {
    $attributes['contact_country_id'] = $attributes['country']['id'];
    $attributes['contact_city_id'] = $attributes['city']['id'];

    unset($attributes['city'], $attributes['country']);

    $school = parent::create(\Arr::except($attributes, ['classrooms']));

    $classrooms = $attributes['classrooms'] ?? [];

    foreach ($classrooms as $classroom) {
      $classroom['school'] = $school->only(['id', 'name']);

      // Ignore id if it is set
      $this->classroomRepository->create(\Arr::except($classroom, ['id']));
    }

    $school->load('classrooms');

    return $school;

  }

  public function update($model, array $attributes)
  {
    $attributes['contact_city_id'] = $attributes['city']['id'];
    $attributes['contact_country_id'] = $attributes['country']['id'];

    unset($attributes['city'], $attributes['country']);

    $model = parent::update($model, \Arr::except($attributes, ['classrooms']));

    $classrooms = $attributes['classrooms'] ?? [];

    $this->classroomRepository
      ->whereBelongsTo($model, 'school');

    foreach ($classrooms as &$classroom) {
      $classroom['school'] = $model->only(['id', 'name']);

      if (isset($classroom['id'])) {
        $this->classroomRepository
          ->update($classroom['id'], \Arr::except($classroom, ['id']));
      } else {
        $classroom = $this->classroomRepository->create(\Arr::except($classroom, ['id']));
      }
    }

    // remove classrooms that are not in the request
    $this->classroomRepository
      ->whereBelongsTo($model, 'school')
      ->whereNotIn('id', array_filter(\Arr::pluck($classrooms, 'id')))
      ->delete();

    $model->load([
      'classrooms' => fn($query) => $query->orderBy('id'),
      "classrooms.classroomType",
    ]);

    return $model;

  }

  public function model()
  {
    return School::class;
  }

  public function allowedIncludes(): array
  {
    return ['city', 'country', 'classrooms', 'cashRegisters'];
  }

  public function allowedFields(): array
  {
    return [
      "id",
      "name",
      "contact_city_id",
      "contact_country_id",
      "cities.id",
      "cities.name",
      "countries.id",
      "countries.name",
      "cashRegisters.id",
      "cashRegisters.name",

      "rtl_name",
      "short_name",
      "active",
      "authorization_date",
      "authorization_number",
      "authorization_information",
      "rtl_authorization_information",
      "cnss",
      "rc",
      "ice",
      'establishment_type',
      'responsible_name',
      'responsible_phone_number',
    ];
  }


  public function allowedSorts(): array
  {
    return [
      'id',
      'name',
      'ice',
      'rc',
      'short_name',
    ];
  }

  public function allowedFilters(): array
  {
    return [
      AllowedFilter::exact('id'),
      AllowedFilter::partial('name'),
      AllowedFilter::partial('ice'),
      AllowedFilter::partial('rc'),
      AllowedFilter::custom('active', BooleanFilter::make()),
      AllowedFilter::exact('city.id', 'contact_city_id'),
      AllowedFilter::exact('country.id', 'contact_country_id'),
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
      'classrooms',
      'classrooms.classroomType',
    ];
  }

}
