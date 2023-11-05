<?php

namespace Modules\Education\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class FormQuestionRequest extends BaseFormRequest
{
    public function commonRules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'description' => 'string',
            'section.id' => 'required|exists:form_sections,id',
            'is_required' => 'required|boolean',
            'order' => 'required|integer',
            'points' => 'nullable|integer|min:0',
            'options' => 'nullable',
        ];
    }

    public function updateRules(): array
    {
        return [
            'title' => 'sometimes',
            'type' => 'sometimes',
            'section.id' => 'sometimes',
            'is_required' => 'sometimes',
            'order' => 'sometimes', 
            'points' => 'sometimes'
        ];
    }
}
