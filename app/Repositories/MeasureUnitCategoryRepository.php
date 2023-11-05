<?php

namespace App\Repositories;

use App\Models\MeasureUnitCategory;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

/**
 * @template T of MeasureUnitCategory
 */
class MeasureUnitCategoryRepository extends BaseRepository
{
  public function __construct(protected MeasureUnitRepository $unitRepository)
  {
    parent::__construct();
  }

  public function create(array $attributes): MeasureUnitCategory
  {
    $category = parent::create(\Arr::except($attributes, ['units']));

    $units = $attributes['units'] ?? [];

    foreach ($units as $unit) {
      $unit['category'] = $category->only(['id', 'name']);

      // Ignore id if it is set
      $this->unitRepository->create(\Arr::except($unit, ['id']));
    }

    $category->load('units');

    return $category;
  }

  public function update($model, array $attributes)
  {
    try {
      \DB::beginTransaction();

      $model = $this->updateModel($model, \Arr::except($attributes, ['units']));

      $units = $attributes['units'] ?? [];

      $this->unitRepository
        ->whereBelongsTo($model, 'category');

      $assignedUnits = collect();

      foreach ($units as $unit) {
        $unit['category'] = $model->only(['id', 'name']);

        if (isset($unit['id'])) {
          $updated = $this->unitRepository
            ->update($unit['id'], \Arr::except($unit, ['id']));

          $assignedUnits->push($updated);
        } else {
          $created = $this->unitRepository->create(\Arr::except($unit, ['id']));

          $assignedUnits->push($created);
        }
      }

      // remove units that are not in the request
      $this->unitRepository
        ->whereBelongsTo($model, 'category')
        ->whereNotIn('id', $assignedUnits->pluck('id'))
        ->delete();

      \DB::commit();

      $model->load([
        'units' => fn($query) => $query->orderBy('id')
      ]);

      return $model;
    } catch (\Throwable $e) {
      \DB::rollBack();
      throw $e;
    }
  }

  public function model()
  {
    return MeasureUnitCategory::class;
  }

  public function allowedIncludes(): array
  {
    return ['units'];
  }

  public function allowedFields(): array
  {
    return [
      "id",
      "name",
    ];
  }

  public function allowedSorts(): array
  {
    return [
      AllowedSort::field('id'),
      AllowedSort::field('name'),
    ];
  }

  public function allowedFilters(): array
  {
    return [
      AllowedFilter::exact('id'),
      AllowedFilter::partial('name'),
    ];
  }

  public function searchFields(): array
  {
    return ['name'];
  }
}
