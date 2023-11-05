<?php

namespace Modules\Education\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class AbsenceRequest extends BaseFormRequest
{
    public function commonRules(): array
    {
        return [
            'absence_type.id'=> 'required|exists:absence_types,id',
            'student.id' => 'required|exists:students,id',
            'achievement.id' => 'required|exists:achievements,id',
            'subscription.id' => 'required|exists:subscriptions,id',
            'date' =>'nullable|date',
            'note' =>'nullable|string|max:255'
        ];
    }

    public function updateRules(): array
    {
        return [
            'absence_type.id'=> 'sometimes',
            'student.id' => 'sometimes',
            'achievement.id' => 'sometimes',
            'subscription.id' => 'sometimes'
        ];
    }

    public function attributes()
    {
        return [
            'absence_type.id'=> 'Absence type',
            'student.id' => 'Student',
            'achievement.id' => 'Achievement',
            'subscription.id' => 'Subscription',
        ];
    }
}
