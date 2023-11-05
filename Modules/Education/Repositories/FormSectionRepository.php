<?php

namespace Modules\Education\Repositories;

use App\Repositories\BaseRepository;
use Modules\Education\Entities\FormSection;
use Spatie\QueryBuilder\AllowedFilter;

class FormSectionRepository extends BaseRepository
{
    protected FormQuestionRepository $questionRepository;

    public function __construct(FormQuestionRepository $questionRepository) {
        $this->questionRepository = $questionRepository;
    }

    public function model()
    {
        return FormSection::class;
    }

    protected function prepareAttributes(array $attributes) : array
    {
        $attributes['form_id'] = $attributes['form']['id'];
        unset($attributes['form']);
        return $attributes;
    }
    public function create(array $attributes) 
    {
        $questions = $attributes['questions'];
        $attributes = $this->prepareAttributes($attributes);

        $section = parent::create(\Arr::except($attributes, 'questions'));

        foreach ($questions as $question) {
            $question['section'] = $section;
            $this->questionRepository->create($question);
        }

        return $section;
    }
    public function update($model, array $attributes)
    {
        $questions = $attributes['questions'];
        $attributes = $this->prepareAttributes($attributes);
        $model = parent::updateModel($model , \Arr::except($attributes, 'questions'));

        foreach ($questions as &$question){
            $question['section'] = $model->only(['id']);
            if (isset($question['id'])) {
                $this->questionRepository->update($question['id'], \Arr::except($question, 'id'));
            } 
            else {
                $this->questionRepository->create($question);
            }
        }
        // remove questions that arent in the request
        $existingQuestions = $model->questions; 
        $requestedQuestionsIds = collect($questions)->pluck('id')->filter()->toArray();

        foreach ($existingQuestions as $question){
            if(!(in_array($question['id'], $requestedQuestionsIds))){
                $question->delete();
            }
        }
        return $model;
    }
    public function delete($model = null): int|bool
    {
        $questions = $model->questions;
        foreach ($questions as $question) {
            $this->questionRepository->delete($question['id']);
        }
        return parent::delete($model['id']); 
    }
    public function defaultIncludes(): array
    {
        return [
            'form' ,
            'questions'
        ];
    }
    public function allowedIncludes(): array
    {
        return [
            'form',
            'questions'
        ];
    }
    public function allowedSorts(): array
    {
        return [
            'title',
            'order'
        ];
    }

    public function searchFields(): array
    {
        return [
            'title',
            'order'
        ];
    }

    public function allowedFields(): array
    {
        return [
            'title',
            'description',
            'form_id' ,
            'form.id' ,
            'form.name',
            'form',
            'questions',
            'order'
        ];
    }
    public function allowedFilters(): array
    {
        return [
            AllowedFilter::exact('id') ,
            AllowedFilter::exact('order') ,
            AllowedFilter::partial('title'),
            AllowedFilter::partial('description')
        ];
    }

}