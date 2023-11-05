<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @template T of \Illuminate\Database\Eloquent\Model
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
abstract class BaseRepository
{
  /**
   * Query builder instance
   *
   * @var QueryBuilder $queryBuilder
   */
  protected QueryBuilder $queryBuilder;

  /**
   * Search query
   *
   * @var string|null $search
   */
  protected string|null $search;

  public function __construct()
  {
    $this->search = request()->input('search', null);
  }

  public function paginate(int $perPage = null)
  {
    return $this
      ->query()
      ->paginate(
        perPage: $perPage
      )
      ->appends(request()->query());
  }

  /**
   * Get query builder
   *
   * @return QueryBuilder
   */
  public function query(): QueryBuilder
  {
    $model = $this->model();

    if (is_string($model)) {
      $keyName = (new $model)->getKeyName();
    } elseif ($model instanceof Builder) {
      $keyName = $model->getModel()->getKeyName();
    }

    $this->queryBuilder ??= QueryBuilder::for($this->model())
      ->defaultSort(AllowedSort::field("-$keyName"))
      ->allowedFields($this->allowedFields())
      ->allowedSorts($this->allowedSorts())
      ->allowedFilters($this->allowedFilters())
      ->allowedIncludes($this->allowedIncludes())
      ->with($this->defaultIncludes())
      ->when(isset($this->search), function (Builder $query) {
        $fields = $this->searchFields();

        $query->where(function (Builder $query) use ($fields) {
          foreach ($fields as $field) {
            $query->orWhere($field, 'LIKE', "%{$this->search}%");
          }
        });
      });

    return $this->queryBuilder;
  }

  /**
   * Find a model by its primary key.
   *
   * @param mixed $id
   *
   * @return T|null
   */
  public function find(mixed $id)
  {
    return $this->query()->find($id);
  }

  /**
   * Find a model by its primary key or throw an exception.
   *
   * @param mixed $id
   *
   * @return T|null
   */
  public function findOrFail(mixed $id)
  {
    // clone query builder to prevent overriding of query builder
    return $this->query()->clone()->findOrFail($id);
  }

  /**
   * The model to execute queries on it
   *
   * @return Builder|string<T>
   */
  abstract public function model();

  /**
   * Get allowed includes
   *
   * @return array
   */
  public function allowedIncludes(): array
  {
    return [];
  }

  /**
   * Get default includes
   *
   * @return array
   */
  public function defaultIncludes(): array
  {
    return [];
  }

  /**
   * Get allowed fields
   *
   * @return array
   */
  public function allowedFields(): array
  {
    return [];
  }

  /**
   * Get allowed sorts
   *
   * @return array
   */
  public function allowedSorts(): array
  {
    return [];
  }

  /**
   * Get allowed filters
   *
   * @return array
   */
  public function allowedFilters(): array
  {
    return [];
  }

  /**
   * Create a new model instance that is existing.
   *
   * @param array $attributes
   * @return T $model | null
   */
  public function create(array $attributes)
  {
    $model = $this->model();

    if (is_string($model)) {
      $model = $model::query();
    }

    /** @var \Illuminate\Database\Eloquent\Model $model */
    $model = $model->create($attributes);

    $model->refresh();

    $model->load($this->defaultIncludes());

    return $model;
  }

  /**
   * Update the model in the database.
   *
   * @param T|int|string $model
   * @param array $attributes
   * @return T
   */
  public function update($model, array $attributes)
  {
    $this->updateModel($model, $attributes);

    $model->refresh();

    $model->load($this->defaultIncludes());

    return $this->findOrFail($model->getKey());
  }

  /**
   * Update the model in the database, used for transactions.
   *
   * @param T|int|string $model
   * @param array $attributes
   *
   * @return T
   */
  public function updateModel(Model|string|int $model, array $attributes)
  {
    if (!($model instanceof Model)) {
      $model = $this->findOrFail($model);
    }

    $model->update($attributes);

    return $model;
  }

  /**
   * Delete the model from the database.
   *
   * @param T|int|string|null $model
   * @return int|bool
   */
  public function delete($model = null): int|bool
  {
    if ($model === null) {
      return $this->query()->delete();
    } elseif (!($model instanceof Model)) {
      $model = $this->findOrFail($model);
      return $model->delete();
    } else {
      return $model->delete();
    }
  }

  public function searchFields(): array
  {
    return [];
  }

  /**
   * Set the search query
   *
   * @param string $search
   *
   * @return static
   */
  public function search(string $search): static
  {
    $this->search = $search;

    return $this;
  }

  public function __call($method, $parameters)
  {
    $response = $this->query()->{$method}(...$parameters);

    if ($response instanceof Builder) {
      return $this;
    }

    return $response;
  }

  public function getEloquentBuilder(): Builder
  {
    return $this->query()->getEloquentBuilder();
  }

  public function rename(array $attributes, array $matches, bool $unset = true)
  {
    $renamed = [];

    foreach ($matches as $key => $value) {
      $renamed[$value] = data_get($attributes, $key);

      if ($unset) {
        $key = \Str::before($key, '.');

        unset($attributes[$key]);
      }
    }

    return array_merge($renamed, $attributes);
  }
}
