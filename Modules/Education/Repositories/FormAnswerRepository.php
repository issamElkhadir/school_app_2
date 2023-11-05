<?php

namespace Modules\Education\Repositories;

use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Modules\Education\Entities\FormAnswer;
use Spatie\QueryBuilder\AllowedFilter;

class FormAnswerRepository extends BaseRepository
{

  public function model()
  {
    return FormAnswer::class;
  }

  private function prepareAttributes(array $attributes): array
  {
    $attributes['participator_id'] = $attributes['participator']['id'];
    unset($attributes['participator']);
    $attributes['question_id'] = $attributes['question']['id'];
    unset($attributes['question']);
    $attributes['section_id'] = $attributes['section']['id'];
    unset($attributes['section']);
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
  public function updateModel(Model|string|int $model, array $attributes)
  {
    $attributes = $this->prepareAttributes($attributes);
    return parent::updateModel($model, $attributes);
  }

  public function allowedIncludes(): array
  {
    return [
        'question:id,title',
        'section:id,title',
        'participator:id,first_name'
    ];
  }

  public function defaultIncludes(): array
  {
    return [
        'question:id,title',
        'section:id,title',
        'participator:id,first_name'
    ];
  }

  public function allowedSorts(): array
  {
    return [
      'id',
      'answer',
    ];
  }

  public function allowedFilters(): array
  {
    return [
      AllowedFilter::exact('id'),
      AllowedFilter::partial('answer'),
    ];
  }

  public function allowedFields(): array
  {
    return [
        'id',
        'answer',
        'participator_id' ,
        'participator',
        'participator.id' ,
        'participator.first_name' ,
        'question' ,
        'question.id',
        'question.title',
        'question_id',
        'section' ,
        'section.id',
        'section.title',
        'section_id'
    ];
  }

  public function searchFields(): array
  {
    return [
        'id',
        'answer',
    ];
  }
}
