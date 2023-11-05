<?php

namespace Modules\Education\Repositories;

use App\Filters\BooleanFilter;
use App\Repositories\BaseRepository;
use Modules\Education\Entities\ContractType;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * @template T of ContractType
 */
class ContractTypeRepository extends BaseRepository
{
    public function model()
    {
        return ContractType::class;
    }

    private function prepareAttributes(array $attributes): array
    {
        $attributes['school_id'] = $attributes['school']['id'];

        unset($attributes['school']);

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
        return ['school:id,name'];
    }

    public function defaultIncludes(): array
    {
        return ['school:id,name'];
    }

    public function allowedSorts(): array
    {
        return [
            'id',
            'name',
            'rtl_name',
            'short_name',
            'description',
            'status',
        ];
    }

    public function allowedFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
            AllowedFilter::partial('name'),
            AllowedFilter::partial('rtl_name'),
            AllowedFilter::partial('short_name'),
            AllowedFilter::partial('description'),
            AllowedFilter::custom('status', new BooleanFilter()),
            AllowedFilter::exact('school.id', 'school_id'),
        ];
    }

    public function allowedFields(): array
    {
        return [
            'id',
            'name',
            'rtl_name',
            'short_name',
            'description',
            'status',
            'school_id',
            'school.id',
            'school.name',
        ];
    }

    public function searchFields(): array
    {
        return [
            'id',
            'name',
            'rtl_name',
            'short_name',
            'description',
        ];
    }
}
