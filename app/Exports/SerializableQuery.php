<?php

namespace App\Exports;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Laravel\SerializableClosure\SerializableClosure;

/** @mixin Builder */
class SerializableQuery implements \Serializable
{
  /**
   * The query to export.
   *
   * @var string
   */
  protected string $sql;

  /**
   * The query bindings.
   *
   * @var array
   */
  protected array $bindings;

  /**
   * The query connection.
   *
   * @var string
   */
  protected string $connection;

  /**
   * The query with.
   *
   * @var array
   */
  protected array $with = [];

  /**
   * The query model.
   *
   * @var string|null
   */
  protected string|null $model;

  /**
   * The query table.
   *
   * @var string|null
   */
  protected string|null $table;

  /**
   * The query columns.
   *
   * @var array
   */
  protected array $columns = [];

  /**
   * The query builder.
   *
   * @var Builder
   */
  protected Builder $query;

  /**
   * Create a new export instance.
   *
   * @param Builder $query
   * @param string|null $table
   */
  public function __construct(Builder $query, string $table = null)
  {
    $this->table = $table ?? $query->getModel()->getTable();

    $this->sql = $query->toSql();

    $this->bindings = $query->getBindings();

    $this->columns = $query->getQuery()->getColumns();

    $this->connection = $query->getConnection()->getName();

    $this->with = $this->serializeEagerLoads($query);

    $this->model = get_class($query->getModel());
  }

  /**
   * @param Builder $builder
   *
   * @return array
   */
  private function serializeEagerLoads($builder): array
  {
    return collect(method_exists($builder, 'getEagerLoads') ? $builder->getEagerLoads() : [])
      ->map(function (Closure $constraint) {
        return new SerializableClosure($constraint);
      })->toArray();
  }

  /**
   * Get the query builder.
   *
   * @return Builder
   */
  public function getQuery(): Builder
  {
    $this->query ??= $this->newQuery();

    return $this->query;
  }

  /**
   * Get a new query builder.
   *
   * @return Builder
   */
  public function newQuery(): Builder
  {
    $query = $this->newModelInstance()->newQuery();

    $query->setEagerLoads($this->eagerLoads());

    foreach ($this->bindings as $binding) {
      $query->addBinding($binding);
    }

    $alias = \Str::replace('.', '_', $this->table);

    // Wrap the query in a subquery so that we can add the table alias
    $from = $query->raw(\DB::raw("({$this->sql}) as $alias"));

    $query->fromRaw($from);

    return $query->withoutGlobalScopes();
  }

  /**
   * Unserialize the query.
   *
   * @return void
   */
  public function unserialize(string $data): void
  {
    [
      'sql' => $this->sql,
      'bindings' => $this->bindings,
      'connection' => $this->connection,
      'with' => $this->with,
      'model' => $this->model,
      'table' => $this->table,
      'columns' => $this->columns,
    ] = unserialize($data);
  }

  /**
   * Serialize the query.
   *
   * @return string
   */
  public function serialize(): string
  {
    return serialize([
      'sql' => $this->sql,
      'bindings' => $this->bindings,
      'connection' => $this->connection,
      'with' => $this->with,
      'model' => $this->model,
      'table' => $this->table,
      'columns' => $this->columns,
    ]);
  }

  /**
   * Get the eager loads.
   *
   * @return array
   */
  private function eagerLoads(): array
  {
    return collect($this->with)->map(function (SerializableClosure $closure) {
      return $closure->getClosure();
    })->toArray();
  }

  /**
   * Get a new instance of the model being queried.
   *
   * @return \Illuminate\Database\Eloquent\Model
   */
  public function newModelInstance(): Model
  {
    $class = '\\' . ltrim($this->model, '\\');

    /** @var \Illuminate\Database\Eloquent\Model $model */
    $model = new $class();

    // Set the connection name on the model
    $model->setConnection($this->connection);

    $model->setTable($this->table);

    return $model;
  }

  /**
   * Get the list of selected columns.
   *
   * @return array
   */
  public function columns(): array
  {
    return $this->columns;
  }

  /**
   * Forward calls to the query builder.
   *
   * @param string $method
   * @param array $parameters
   *
   * @return mixed
   */

  public function __call($method, $parameters)
  {
    $result = $this->getQuery()->$method(...$parameters);

    return $result;
  }
}
