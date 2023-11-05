<?php

namespace Modules\Education\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class PreInscriptionRequest extends BaseFormRequest
{
    public function commonRules(): array
    {
        return [
            'title' => 'required|string|min:0',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
            'start_date_time' => 'date|required',
            'end_date_time' => 'date|required',
            'form.id' => 'required|exists:forms,id',
            'school.id' => 'required|exists:schools,id',
            'level.id' => 'required|exists:levels,id',
        ];
    }

    public function updateRules(): array
    {
        return [
            'title' => 'sometimes',
            'status' => 'sometimes',
            'start_date_time' => 'sometimes',
            'end_date_time' => 'sometimes',
            'form.id' => 'sometimes',
            'school.id' => 'sometimes',
            'level.id' => 'sometimes',
        ];
    }

    public function attributes()
    {
        return [
            'start_date_time' => 'start date time',
            'end_date_time' => 'end date time',
            'form.id' => 'form',
            'school.id' => 'school',
            'level.id' => 'level',
        ];
    }
}
