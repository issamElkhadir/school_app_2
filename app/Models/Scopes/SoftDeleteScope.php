<?php

namespace App\Models\Scopes;

use App\Traits\Trackable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class SoftDeleteScope implements Scope
{
  /**
   * All the extensions to be added to the builder.
   *
   * @var string[]
   */
  protected array $cascadeSoftDeleteExtensions = ['RestoreTrashed', 'OnlyTrashed', 'WithTrashed', 'WithoutTrashed'];

  /**
   * Apply the scope to a given Eloquent query builder.
   *
   * @param Builder $builder
   * @param Model $model
   * @return void
   */
  public function apply(Builder $builder, Model $model): void
  {
    /** @var Trackable $model */
    $builder->whereNull($model->getQualifiedDeletedAtColumn());
  }

  /**
   * Extend the query builder with the needed functions.
   *
   * @param Builder $builder
   * @return void
   */
  public function extend(Builder $builder): void
  {
    foreach ($this->cascadeSoftDeleteExtensions as $extension) {
      $this->{"add{$extension}"}($builder);
    }

    $builder->onDelete(function (Builder $builder) {
      $archivedAtColumn = $this->getDeletedAtColumn($builder);
      $archivedByColumn = $this->getDeletedByColumn($builder);

      return $builder->update([
        $archivedAtColumn => $builder->getModel()->freshTimestampString(),
        $archivedByColumn => auth()->id()
      ]);
    });
  }

  /**
   * Get the "deleted at" column for the builder.
   *
   * @param Builder $builder
   * @return string
   */
  protected function getDeletedAtColumn(Builder $builder): string
  {
    /** @var Trackable $model */
    $model = $builder->getModel();

    if (count($builder->getQuery()->joins ?? []) > 0) {
      return $model->getQualifiedDeletedAtColumn();
    }

    return $model->getDeletedAtColumn();
  }

  /**
   * Get the "deleted at" column for the builder.
   *
   * @param Builder $builder
   * @return string
   */
  protected function getDeletedByColumn(Builder $builder): string
  {
    /** @var Trackable $model */
    $model = $builder->getModel();

    if (count($builder->getQuery()->joins ?? []) > 0) {
      return $model->getQualifiedDeletedByColumn();
    }

    return $model->getDeletedByColumn();
  }

  /**
   * Add the with-trashed extension to the builder.
   *
   * @param Builder $builder
   * @return void
   */
  protected function addWithTrashed(Builder $builder): void
  {
    $builder->macro('withTrashed', function (Builder $builder, $withTrached = true) {
      if (!$withTrached) {
        return $builder->withoutTrashed();
      }

      return $builder->withoutGlobalScope($this);
    });
  }

  /**
   * Add the without-trashed extension to the builder.
   *
   * @param Builder $builder
   * @return void
   */
  protected function addWithoutTrashed(Builder $builder): void
  {
    $builder->macro('withoutTrashed', function (Builder $builder) {
      /** @var Trackable $model */
      $model = $builder->getModel();

      $builder->withoutGlobalScope($this)->whereNull(
        $model->getQualifiedDeletedAtColumn()
      );

      return $builder;
    });
  }

  /**
   * Add the only-trashed extension to the builder.
   *
   * @param Builder $builder
   * @return void
   */
  protected function addOnlyTrashed(Builder $builder): void
  {
    $builder->macro('onlyTrashed', function (Builder $builder) {
      /** @var Trackable $model */
      $model = $builder->getModel();

      $builder->withoutGlobalScope($this)->whereNotNull(
        $model->getQualifiedDeletedAtColumn()
      );

      return $builder;
    });
  }

  /**
   * Add the restore trashed extension to the builder.
   *
   * @param Builder $builder
   * @return void
   */
  protected function addRestoreTrashed(Builder $builder): void
  {
    $builder->macro('restoreTrashed', function (Builder $builder) {
      $builder->withTrashed();

      /** @var self $model */
      $model = $builder->getModel();

      return $builder->update([
        $model->getDeletedAtColumn($builder) => null,
      ]);
    });
  }
}
