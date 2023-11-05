<?php

namespace Modules\Education\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class FormSectionRequest extends BaseFormRequest
{
    public function commonRules(): array
    {
        return [
            'title'=> 'required|string|max:255',
            'description' => 'nullable|string',
            'form.id' => 'required|exists:forms,id',
            'form.name' => 'string'
        ];
    }
    public function updateRules(): array
    {
        return [
            'title'=> 'sometimes',
            'form.id' => 'sometimes'
        ];
    }

    public function attributes()
    {
        return [
            'form.id' => 'form'
        ];
    }
}
