<?php

namespace Modules\Education\Repositories;

use App\Filters\BooleanFilter;
use App\Repositories\BaseRepository;
use Modules\Education\Entities\Achievement;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * @template T of Achievement
 */
class AchievementRepository extends BaseRepository
{

    public function create(array $attributes)
    {

        $attributes['class_id'] = $attributes['class']['id'];
        $attributes['achievement_type_id'] = $attributes['achievement_type']['id'];
        $attributes['school_id'] = $attributes['school']['id'];

        unset($attributes['class'], $attributes['achievement_type'], $attributes['school']);

        $attributes['achievable_id'] = $attributes['achievable']['achievable_id'];
        $attributes['achievable_type'] = $attributes['achievable']['achievable_type'];

        unset($attributes['achievable']);

        return parent::create($attributes);
    }

    public function update($model, array $attributes)
    {
        if (isset($attributes['achievable'])) {
            $attributes['achievable_id'] = $attributes['achievable']['achievable_id'];
            $attributes['achievable_type'] = $attributes['achievable']['achievable_type'];

            unset($attributes['achievable']);
        }

        if (isset($attributes['class'])) {
            $attributes['class_id'] = $attributes['class']['id'];
        }

        if (isset($attributes['achievement_type'])) {
            $attributes['achievement_type_id'] = $attributes['achievement_type']['id'];
        }

        if (isset($attributes['school'])) {
            $attributes['school_id'] = $attributes['school']['id'];
        }
        unset($attributes['class'], $attributes['achievement_type'], $attributes['school']);

        return parent::update($model, $attributes);

    }

    public function model()
    {
        return Achievement::class;
    }

    public function allowedIncludes(): array
    {
        return ['class:id,name', 'achievementType:id,name', 'school:id,name', 'achievable'];
    }

    public function defaultIncludes(): array
    {
        return [
            'class:id,name',
            'achievementType:id,name',
            'school:id,name',
            'achievable',
        ];
    }

    public function allowedFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
            AllowedFilter::custom('is_realised', new BooleanFilter()),
        ];
    }

    public function allowedFields(): array
    {
        return [
            'id',

            'class_id',
            'classes.id',
            'classes.name',

            'start_time',
            'end_time',
            'date',

            'achievement_type_id',
            'achievementTypes.id',
            'achievementTypes.name',

            'is_realised',
            'delay_time',
            'note',

            'school_id',
            'schools.id',
            'schools.name',

            "created_at",
            "updated_at",
        ];
    }

    public function searchFields(): array
    {
        return [
            'id',
            'start_time',
            'date'
        ];
    }

    public function allowedSorts(): array
    {
        return [
            'id',
            'start_time',
            'end_time',
            'date',
            'is_realised',
            'delay_time',
            'note'
        ];
    }

}
