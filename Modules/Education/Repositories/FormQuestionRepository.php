<?php

namespace Modules\Education\Repositories;

use App\Filters\BooleanFilter;
use App\Repositories\BaseRepository;
use Modules\Education\Entities\FormQuestion;
use Spatie\QueryBuilder\AllowedFilter;

class FormQuestionRepository extends BaseRepository
{
    public function model()
    {
        return FormQuestion::class;
    }
    protected function prepareAttributes(array $attributes) : array
    {
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
        return parent::updateModel($model ,$attributes);
    }
    public function allowedSorts(): array
    {
        return [
            'title',
            'type' ,
            'section_id' ,
            'order',
            'points',
            'is_required' 
        ];
    }

    public function defaultIncludes(): array
    {
        return [
            'section:id'
        ];
    }
    public function searchFields(): array
    {
        return [
            'title',
            'type' ,
            'section_id' ,
            'is_required'  ,
            'order' ,
            'points'
        ];
    }

    public function allowedFields(): array
    {
        return [
            'title',
            'type' ,
            'description' ,
            'section_id' ,
            'is_required' , 
            'options' ,
            'section' ,
            'section.id' ,
            'order' ,
            'points'
        ];
    }
    public function allowedFilters(): array
    {
        return [
            AllowedFilter::exact('id') ,
            AllowedFilter::partial('title'),
            AllowedFilter::partial('type') ,
            AllowedFilter::partial('description') ,
            AllowedFilter::exact('section.id' , 'section_id') ,
            AllowedFilter::exact('order') ,
            AllowedFilter::exact('points') ,
            AllowedFilter::custom('is_required' , new BooleanFilter()) ,
        ];
    }

}