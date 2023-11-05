<?php

namespace Modules\Education\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class FormAnswerRequest extends BaseFormRequest
{
    public function commonRules(): array
    {
        return [
            'answer' => 'required|array' ,
            'participator.id' => 'required|exists:participators,id' ,
            'question.id' => 'required|exists:form_questions,id',
            'section.id' => 'required|exists:form_sections,id'
        ];
    }

    public function updateRules(): array
    {
        return [
            'answer' => 'sometimes' ,
            'participator.id' => 'sometimes' ,
            'question.id' => 'sometimes',
            'section.id' => 'sometimes'
        ];
    }

    public function attributes()
    {
        return [
            'participator.id' => 'participator' ,
            'question.id' => 'question',
            'section.id' => 'section',
        ];
    }
}
