<?php

namespace Modules\Education\Repositories;

use App\Repositories\BaseRepository;
use Modules\Education\Entities\Participator;
use Spatie\QueryBuilder\AllowedFilter;

class ParticipatorRepository extends BaseRepository
{

  public function model()
  {
    return Participator::class;
  }

  private function prepareAttributes(array $attributes): array
  {
    if(isset($attributes['student'])){
      $attributes['student_id'] = $attributes['student']['id'];
      unset($attributes['student']);
    }
    $attributes['form_id'] = $attributes['form']['id'];
    unset($attributes['form']);
    return $attributes;
  }

  public function create(array $attributes)
  {
    $attributes = $this->prepareAttributes($attributes);
    return parent::create($attributes);
  }

  public function update($model, array $attributes)
  {
    $attributes = $this->prepareAttributes($attributes);
    return parent::update($model, $attributes);
  }

  public function allowedIncludes(): array
  {
    return [
        'student:id,first_name',
        'form:id,name'
    ];
  }

  public function defaultIncludes(): array
  {
    return [
        'student:id,first_name',
        'form:id,name'
    ];
  }

  public function allowedSorts(): array
  {
    return [
      'id',
      'first_name',
      'last_name',
      'email',
      'token',
    ];
  }

  public function allowedFilters(): array
  {
    return [
      AllowedFilter::exact('id'),
      AllowedFilter::partial('first_name'),
      AllowedFilter::partial('last_name'),
      AllowedFilter::partial('email'),
      AllowedFilter::partial('token')
    ];
  }

  public function allowedFields(): array
  {
    return [
        'id',
        'first_name',
        'last_name',
        'email',
        'token',
        'password',
        'student_id' ,
        'student',
        'student.id' ,
        'student.name' ,
        'form' ,
        'form.id',
        'form.name',
        'form_id'
    ];
  }

  public function searchFields(): array
  {
    return [
        'id',
        'first_name',
        'last_name',
        'email',
        'token',
    ];
  }
}
