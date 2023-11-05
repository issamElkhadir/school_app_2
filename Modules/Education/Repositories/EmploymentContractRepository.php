<?php

namespace Modules\Education\Repositories;

use App\Filters\DateAfterFilter;
use App\Repositories\BaseRepository;
use Modules\Education\Entities\EmploymentContract;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * @template T of EmploymentContract
 */
class EmploymentContractRepository extends BaseRepository
{
    public function model()
    {
        return EmploymentContract::class;
    }

    private function prepareAttributes(array $attributes): array
    {
        $attributes['staff_id'] = $attributes['staff']['id'];
        unset($attributes['staff']);

        $attributes['contract_type_id'] = $attributes['contract_type']['id'];
        unset($attributes['contract_type']);

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
            'staff:id,name',
            'contract_type:id,name'
        ];
    }

    public function defaultIncludes(): array
    {
        return [
            'staff:id,name',
            'contract_type:id,name'
        ];
    }

    public function allowedSorts(): array
    {
        return [
            'id',
            'contract_start_date',
            'contract_end_date',
            'net_salary',
            'brut_salary',
            'nbr_days_off'
        ];
    }

    public function allowedFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
            AllowedFilter::custom('contract_start_date', new DateAfterFilter()),
            AllowedFilter::custom('contract_end_date', new DateAfterFilter()),
            AllowedFilter::partial('net_salary'),
            AllowedFilter::partial('brut_salary'),
            AllowedFilter::partial('nbr_days_off'),
            AllowedFilter::exact('staff.id', 'staff_id'),
            AllowedFilter::exact('contract_type.id', 'contract_type_id'),
        ];
    }

    public function allowedFields(): array
    {
        return [
            'id',
            'contract_start_date',
            'contract_end_date',
            'net_salary',
            'brut_salary',
            'nbr_days_off',

            'staff_id',
            'staff.id',
            'staff.name',

            'contract_type_id',
            'contract_types.id',
            'contract_types.name',
        ];
    }

    public function searchFields(): array
    {
        return [
            'id',
            'contract_start_date',
            'contract_end_date',
            'net_salary',
            'brut_salary',
            'nbr_days_off'
        ];
    }
}
