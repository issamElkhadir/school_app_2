<?php

namespace Modules\Education\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class EmploymentContractRequest extends BaseFormRequest
{
    public function commonRules(): array
    {
        return [
            'staff.id' => 'required|exists:staff,id',
            'contract_start_date' =>'nullable|date',
            'contract_end_date' =>'nullable|date',
            'net_salary' =>'nullable|numeric|min:0',
            'brut_salary' =>'nullable|numeric|min:0',
            'nbr_days_off' =>'nullable|numeric|min:0',
            'contract_type.id' => 'required|exists:contract_types,id',
        ];
    }

    public function updateRules(): array
    {
        return [
            'staff.id' => 'sometimes' ,
            'contract_type.id' =>'sometimes',
        ];
    }

    public function attributes()
    {
        return [
            'staff.id' => 'Staff' ,
            'contract_start_date' => 'Contract start date',
            'contract_end_date' => 'Contract end date' ,
            'net_salary' => 'Net salary',
            'brut_salary' => 'Brut salary',
            'nbr_days_off' => 'Number days off',
            'contract_type.id' => 'Contract type',
        ];
    }
}
