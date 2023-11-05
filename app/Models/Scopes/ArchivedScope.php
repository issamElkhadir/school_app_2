<?php

namespace App\Models\Scopes;

use App\Traits\Trackable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ArchivedScope implements Scope
{
    /**
     * All the extensions to be added to the builder.
     *
     * @var string[]
     */
    protected array $archivedExtensions = ['RestoreArchived', 'WithArchived', 'WithoutArchived', 'OnlyArchived'];

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
        $builder->whereNull($model->getQualifiedArchivedAtColumn());
    }

    /**
     * Extend the query builder with the needed functions.
     *
     * @param Builder $builder
     * @return void
     */
    public function extend(Builder $builder): void
    {
        foreach ($this->archivedExtensions as $extension) {
            $this->{"add{$extension}"}($builder);
        }

        $builder->onDelete(function (Builder $builder) {
            $archivedAtColumn = $this->getArchivedAtColumn($builder);
            $archivedByColumn = $this->getArchivedByColumn($builder);

            return $builder->update([
                $archivedAtColumn => $builder->getModel()->freshTimestampString(),
                $archivedByColumn => auth()->id()
            ]);
        });
    }

    /**
     * Get the "archived at" column for the builder.
     *
     * @param Builder $builder
     * @return string
     */
    protected function getArchivedAtColumn(Builder $builder): string
    {
        /** @var Trackable $model */
        $model = $builder->getModel();

        if (count($builder->getQuery()->joins ?? []) > 0) {
            return $model->getQualifiedArchivedAtColumn();
        }

        return $model->getArchivedAtColumn();
    }

    /**
     * Get the "archived by" column for the builder.
     *
     * @param Builder $builder
     * @return string
     */
    protected function getArchivedByColumn(Builder $builder): string
    {
        /** @var Trackable $model */
        $model = $builder->getModel();

        if (count($builder->getQuery()->joins ?? []) > 0) {

            return $model->getQualifiedArchivedByColumn();
        }

        return $model->getArchivedByColumn();
    }

    /**
     * Add the with-archived extension to the builder.
     *
     * @param Builder $builder
     * @return void
     */
    protected function addWithArchived(Builder $builder): void
    {
        $builder->macro('withArchived', function (Builder $builder, $withArchived = true) {
            if (!$withArchived) {
                return $builder->withoutArchived();
            }

            return $builder->withoutGlobalScope($this);
        });
    }

    /**
     * Add the without-archived extension to the builder.
     *
     * @param Builder $builder
     * @return void
     */
    protected function addWithoutArchived(Builder $builder): void
    {
        $builder->macro('withoutArchived', function (Builder $builder) {
            /** @var Trackable $model */
            $model = $builder->getModel();

            $builder->withoutGlobalScope($this)->whereNull(
                $model->getQualifiedArchivedAtColumn()
            );

            return $builder;
        });
    }

    /**
     * Add the only-archived extension to the builder.
     *
     * @param Builder $builder
     * @return void
     */
    protected function addOnlyArchived(Builder $builder): void
    {
        $builder->macro('onlyArchived', function (Builder $builder) {
            /** @var Trackable $model */
            $model = $builder->getModel();

            $builder->withoutGlobalScope($this)
                ->whereNotNull($model->getQualifiedArchivedAtColumn());

            return $builder;
        });
    }

    /**
     * Add the restore archived extension to the builder.
     *
     * @param Builder $builder
     * @return void
     */
    protected function addRestoreArchived(Builder $builder): void
    {
        $builder->macro('restoreArchived', function (Builder $builder) {
            $builder->withArchived();

            /** @var self $model */
            $model = $builder->getModel();

            return $builder->update([
                $model->getArchivedAtColumn($builder) => null,
                $model->getArchivedByColumn($builder) => null,
            ]);
        });
    }
}
