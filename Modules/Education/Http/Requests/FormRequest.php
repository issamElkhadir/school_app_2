<?php

namespace Modules\Education\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class FormRequest extends BaseFormRequest
{

    public function commonRules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'nullable|integer|min:0',
            'preferences' => 'required|array',
            'sections' => 'required|array',
            'sections.*.title' => 'required|string',
            'sections.*.order' => 'required|integer',
            'sections.*.description' => 'nullable|string',
            'sections.*.questions' => 'required|array' ,
            'sections.*.questions.*.title' => 'required|string',
            'sections.*.questions.*.type' => 'required|string',
            'sections.*.questions.*.description' => 'nullable|string',
            'sections.*.questions.*.is_required' => 'required|boolean',
            'sections.*.questions.*.points' => 'nullable|integer|min:0',
            'sections.*.questions.*.order' => 'required|integer',
            'sections.*.questions.*.options' => 'nullable|array',
        ];
    }
    public function updateRules(): array
    {
        return [
            'name' => 'sometimes',
            'duration' => 'sometimes',
            'preferences' => 'sometimes',
            'sections' => 'sometimes',
            'sections.*.title' => 'sometimes',
            'sections.*.order' => 'sometimes',
            'sections.*.questions' => 'sometimes' ,
            'sections.*.questions.*.title' => 'sometimes',
            'sections.*.questions.*.type' => 'sometimes',
            'sections.*.questions.*.is_required' => 'sometimes' ,
            'sections.*.questions.*.order' => 'sometimes' ,
            'sections.*.questions.*.points' => 'sometimes' ,
            'sections.*.id' => 'sometimes|integer|exists:form_sections,id',
            'sections.*.questions.*.id' => 'sometimes|integer|exists:form_questions,id',
        ];
    }

    public function attributes()
    {
        return [
            'sections.*.questions' => 'questions',
            'sections.*.title' => 'section title',  
            'sections.*.questions.*.title' => 'question title',  
        ];
    }
}
