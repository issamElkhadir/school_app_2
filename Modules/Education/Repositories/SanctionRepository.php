<?php

namespace Modules\Education\Repositories;

use App\Repositories\BaseRepository;
use Modules\Education\Entities\Sanction;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * @template T of Sanction
 */
class SanctionRepository extends BaseRepository
{
    public function create(array $attributes)
    {
        $attributes['staff_id'] = $attributes['staff']['id'];
        $attributes['sanction_type_id'] = $attributes['sanction_type']['id'];

        unset($attributes['staff'], $attributes['sanction_type']);

        return parent::create($attributes);
    }

    public function update($model, array $attributes)
    {
        $attributes['staff_id'] = $attributes['staff']['id'];
        $attributes['sanction_type_id'] = $attributes['sanction_type']['id'];

        unset($attributes['staff'], $attributes['sanction_type']);

        return parent::update($model, $attributes);
    }


    public function model()
    {
        return Sanction::class;
    }
    public function allowedIncludes(): array
    {
        return ['staff:id,name', 'sanctionType:id,name'];
    }

    public function allowedFields(): array
    {
        return [
            "id",
            "staff_id",
            "date",
            "reason",
            "description",
            "decision",
            "sanction_type_id",
            "staff.id",
            "staff.name",
            "sanctionTypes.id",
            "sanctionTypes.name",
            "created_at",
            "updated_at",
        ];
    }

    public function allowedSorts(): array
    {
        return [
            'id',
            'date',
            'created_at',
            'updated_at',
        ];
    }

    public function allowedFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('staff.id', 'staff_id'),
            AllowedFilter::exact('sanctionType.id', 'sanction_type_id'),
            AllowedFilter::exact('date'),
            AllowedFilter::partial('reason'),
        ];
    }


    public function searchFields(): array
    {
        return [
            'id',
            'reason',
        ];
    }

    public function defaultIncludes(): array
    {
        return ['staff:id,name', 'sanctionType:id,name'];
    }
}
