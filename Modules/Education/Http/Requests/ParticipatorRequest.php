<?php

namespace Modules\Education\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class ParticipatorRequest extends BaseFormRequest
{
    public function commonRules(): array
    {
        return [
            'first_name' => 'string|required|min:0',
            'last_name' => 'string|required|min:0',
            'email' => 'string|required|min:0',
            'password' => 'string|required|min:0',
            'token' => 'string|required|min:0',
            'student.id' => 'required|exists:students,id',
            'form.id' => 'required|exists:forms,id'
        ];
    }

    public function updateRules(): array
    {
        return [
            'first_name' => 'sometimes',
            'last_name' => 'sometimes',
            'email' => 'sometimes',
            'password' => 'sometimes',
            'token' => 'sometimes',
            'student.id' => 'sometimes',
            'form.id' => 'sometimes'
        ];
    }

    public function attributes()
    {
        return [
            'form.id' => 'form' ,
            'student.id' => 'student'
        ];
    }
}
