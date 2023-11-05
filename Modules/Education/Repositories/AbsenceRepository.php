<?php

namespace Modules\Education\Repositories;

use App\Filters\DateAfterFilter;
use App\Repositories\BaseRepository;
use Modules\Education\Entities\Absence;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * @template T of Absence
 */
class AbsenceRepository extends BaseRepository
{
    public function model()
    {
        return Absence::class;
    }
    private function prepareAttributes(array $attributes): array
    {
        $attributes['absence_type_id'] = $attributes['absence_type']['id'];
        unset($attributes['absence_type']);

        $attributes['student_id'] = $attributes['student']['id'];
        unset($attributes['student']);

        $attributes['achievement_id'] = $attributes['achievement']['id'];
        unset($attributes['achievement']);

        $attributes['subscription_id'] = $attributes['subscription']['id'];
        unset($attributes['subscription']);

        return $attributes;
    }

    public function create(array $attributes)
    {
        $attributes = $this->prepareAttributes($attributes);

        return parent::create($attributes);
    }

    public function update($model, array $attributes)
    {
        $attributes = $this->prepareAttributes($attributes);

        return parent::update($model, $attributes);
    }


    public function allowedIncludes(): array
    {
        return [
            'absence_type:id,name',
            'student:id,first_name,last_name' ,
            'achievement',
            'achievement.achievable',
            'subscription:id,sequence' 
        ];
    }

    public function defaultIncludes(): array
    {
        return [
            'absence_type:id,name',
            'student:id,first_name,last_name' ,
            'achievement',
            'achievement.achievable',
            'subscription:id,sequence'
        ];
    }

    public function allowedSorts(): array
    {
        return [
            'id',
            'date' 
        ];
    }

    public function allowedFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
            AllowedFilter::custom('date', new DateAfterFilter()),
            AllowedFilter::partial('note'),
            AllowedFilter::exact('student.id', 'student_id'),
            AllowedFilter::exact('absence_type.id', 'absence_type_id'),
            AllowedFilter::exact('achievement.id', 'achievement_id'),
            AllowedFilter::exact('subscription.id', 'subscription_id'),
        ];
    }

    public function allowedFields(): array
    {
        return [
            'id',
            'note',
            'date',

            'student_id',
            'students.id',
            'students.first_name',
            'students.last_name',

            'absence_type_id',
            'absence_types.id',
            'absence_types.name',

            'achievement_id',
            'achievements.id',
            'achievements.achievable',

            'subscription_id',
            'subscriptions.id',
            'subscriptions.sequence',
        ];
    }

    public function searchFields(): array
    {
        return [
            'id',
            'date',

        ];
    }
}