<?php

namespace Modules\Education\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class ContractTypeRequest extends BaseFormRequest
{
    public function commonRules(): array
    {
        return [
            'school.id' => 'required|exists:schools,id',
            'name' => 'required|string|max:255',
            'rtl_name' => 'nullable|string|max:255',
            'short_name' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ];
    }

    public function updateRules(): array
    {
        return [
            'school.id' => 'sometimes',
            'name' => 'sometimes',
            'rtl_name' => 'sometimes',
            'short_name' => 'sometimes',
            'description' => 'sometimes',
            'status' => 'sometimes',
        ];
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        return [
            'school.id' => 'School',
            'name' => 'Contract type name',
            'rtl_name' => 'RTL contract type name',
            'short_name' => 'Contract type short name',
        ];
    }
}
