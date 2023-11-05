<?php

namespace App\Exports;

use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithMapping;

abstract class QueryExport implements FromQuery, WithCustomCsvSettings, ShouldAutoSize, WithMapping
{
  use Exportable;

  /**
   * The CSV settings.
   *
   * @var array
   */
  protected array $csvSettings = [
    'delimiter' => ';',
    'enclosure' => '"',
    'line_ending' => "\r\n",
    'use_bom' => true,
    // 'include_separator_line' => true,
    // 'excel_compatibility' => true,
  ];

  /**
   * The eloquent query to export, wrapped with SerializableQuery.
   *
   * @var SerializableQuery
   */
  protected SerializableQuery $serializableQuery;

  /**
   * Compatible with import.
   *
   * @var bool
   */
  protected bool $importable = false;

  public function __construct()
  {
    $repository = $this->repository();

    $this->serializableQuery = new SerializableQuery($repository->query()->getEloquentBuilder());
  }

  /**
   * @return Builder|EloquentBuilder|Relation
   */
  public function query(): Builder|EloquentBuilder|Relation
  {
    return $this->serializableQuery->getQuery();
  }

  /**
   * Get the headings row.
   *
   * @return array
   */
  public function headings(): array
  {
    $query = $this->serializableQuery->getQuery();

    $selectColumns = $query->qualifyColumns($this->getSelectColumns());

    $exportable = collect($this->allowedExports());

    $columns = $query->qualifyColumns($this->getAllowedColumns());

    if (!in_array('*', $selectColumns)) {
      $columns = array_intersect($selectColumns, $columns);
    }

    if (empty($columns)) {
      if ($this->importable) {
        $headings = $this->getAllowedColumns();
      } else {
        $headings = $this->getAllowedLabels();
      }
    } else {
      $columns = array_map(function ($column) use ($exportable, $query) {
        $field = $exportable->first(fn($field) => $query->qualifyColumn($field->getInternalName()) === $column);

        if (!$field) {
          return null;
        }

        if ($this->importable) {
          return $field->getAttribute();
        } else {
          return $field->getLabel();
        }
      }, $columns);

      $headings = array_filter($columns);
    }

    return $headings;
  }

  /**
   * The columns allowed to export.
   *
   * @return array<int, AllowedExport>
   */
  public abstract function allowedExports(): array;

  /**
   * The repository instance.
   *
   * @return BaseRepository
   */
  public abstract function repository(): BaseRepository;

  /**
   * @param \Illuminate\Database\Eloquent\Model $model
   *
   * @return array
   */
  public function map($model): array
  {
    $allowed = $this->allowedExports();

    $map = [];

    foreach ($allowed as $field) {
      $map[$field->getAttribute()] = $field->getValue($model);
    }

    return $map;
  }

  /**
   * Get the CSV settings.
   *
   * @return array
   */
  public function getCsvSettings(): array
  {
    return $this->csvSettings;
  }

  /**
   * Set the CSV settings.
   *
   * @param array $settings
   *
   * @return static
   */
  public function setCsvSettings(array $settings): static
  {
    $this->csvSettings = array_merge($this->csvSettings, $settings);

    return $this;
  }

  public function setImportable(bool $importable): static
  {
    $this->importable = $importable;

    return $this;
  }

  /**
   * Get the allowed columns.
   *
   * @return array
   */
  protected function getAllowedColumns(): array
  {
    return array_map(fn($col) => $col->getInternalName(), $this->allowedExports());
  }

  /**
   * Get the allowed columns labels.
   *
   * @return array
   */
  protected function getAllowedLabels(): array
  {
    return array_map(fn($col) => $col->getLabel(), $this->allowedExports());
  }

  /**
   * Get the list of columns to be selected.
   *
   * @return array
   */
  private function getSelectColumns(): array
  {
    $selectColumns = $this->serializableQuery->columns();

    if (empty($selectColumns) || in_array('*', $selectColumns)) {
      return $selectColumns;
    }

    foreach ($selectColumns as $index => $col) {
      if (is_string($col) && str_contains($col, ' as ')) {
        $selectColumns[$index] = trim(\Str::afterLast($col, ' as '), "\n\r\t\v\x00\"");
      }
    }

    return $selectColumns;
  }
}
