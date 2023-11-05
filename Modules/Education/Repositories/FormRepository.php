<?php

namespace Modules\Education\Repositories;

use App\Filters\BooleanFilter;
use App\Repositories\BaseRepository;
use Modules\Education\Entities\Form;
use Spatie\QueryBuilder\AllowedFilter;

class FormRepository extends BaseRepository
{
    protected FormSectionRepository $sectionRepository;

    public function __construct(FormSectionRepository $sectionRepository)
    {
        $this->sectionRepository = $sectionRepository;
    }

    public function model()
    {
        return Form::class;
    }
    public function create(array $attributes)
    {
        try {
            \DB::beginTransaction();

            $sections = $attributes['sections'];
            // generate form slug
            $attributes['slug'] = uniqid(\Str::slug($attributes['name']) . '-');
            $form = parent::create(\Arr::except($attributes, 'sections'));

            foreach ($sections as $section) {
                $section['form'] = $form->only(['id' , 'name']);
                $this->sectionRepository->create($section);
            }

            \DB::commit();

            $form->load('sections.questions');

            return $form;
        } catch (\Throwable $e) {
            \DB::rollBack();
            throw $e;
        }
    }
    public function update($model, array $attributes)
    {
        try {
            \DB::beginTransaction();
            $sections = $attributes['sections'];
            // generate form slug
            $attributes['slug'] = uniqid(\Str::slug($attributes['name']) . '-');
            $model = parent::update($model , \Arr::except($attributes , 'sections'));

            foreach ($sections as &$section){
                $section['form'] = $model->only(['id']);
                if (isset($section['id'])) {
                    $this->sectionRepository->update($section['id'], \Arr::except($section , 'id'));
                } 
                else {
                    $this->sectionRepository->create($section);
                }
            }
            // remove sections that arent in the request
            $existingSections = $model->sections; 
            $requestedSectionsIds = collect($sections)->pluck('id')->filter()->toArray();

            if($existingSections){
                foreach ($existingSections as $section){
                    if(!(in_array($section['id'], $requestedSectionsIds))){
                        if($section->questions){
                            foreach ($section->questions as $question){
                                $question->delete();
                            }
                        }
                        $section->delete();
                    }
                }
            }
            \DB::commit();
            $model->load('sections.questions');
            return $model;
        }catch (\Throwable $e) {
            \DB::rollBack();
            throw $e;
        }
    }
    public function delete($model = null): int|bool
    {
        try {
            \DB::beginTransaction();
            $model->load('sections.questions');
            $sections = $model->sections; 
            foreach ($sections as $section){
                $this->sectionRepository->delete($section);
            }
            $deletedForm = parent::delete($model['id']);
            \DB::commit();
            return $deletedForm;
        }catch (\Throwable $e) {
            \DB::rollBack();
            throw $e;
        }
    }
    public function allowedSorts(): array
    {
        return [
            'id',
            'name',
            'slug',
            'description',
            'duration',
            'is_active'
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
            'sections',
            'sections.questions',
        ];
    }

    public function allowedIncludes(): array
    {
        return [
            'sections',
            'sections.questions',
        ];
    }
    public function allowedFields(): array
    {
        return [
            'id',
            'name',
            'slug',
            'description',
            'duration',
            'is_active',
            'preferences',
            'sections'
        ];
    }
    public function allowedFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
            AllowedFilter::partial('name'),
            AllowedFilter::partial('slug'),
            AllowedFilter::partial('description'),
            AllowedFilter::partial('duration'),
            AllowedFilter::custom('is_active', new BooleanFilter())
        ];
    }
}
