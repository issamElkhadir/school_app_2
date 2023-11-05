<?php

namespace App\Exports;
use App\Exports\FieldsExport\BelongsToExport;
use App\Exports\FieldsExport\ExportInterface;
use App\Exports\FieldsExport\FieldExport;
use App\Exports\FieldsExport\MorphToExport;

class AllowedExport
{
  /**
   * The attribute to export.
   *
   * @var string
   */
  protected string $attribute;

  /**
   * The attribute label.
   *
   * @var string
   */
  protected string $label;

  /**
   * The internal name for the attribute.
   */
  protected string $internalName;

  /**
   * The exporter class for the attribute.
   *
   * @var ExportInterface
   */
  protected ExportInterface $exporter;

  public function __construct(string $attribute, string $label, ExportInterface $exporter, string $internalName = null)
  {
    $this->attribute = $attribute;
    $this->label = $label;
    $this->exporter = $exporter;
    $this->internalName = $internalName ?? $attribute;
  }

  public static function column(string $column, string $label): static
  {
    $exporter = new FieldExport();

    return new static($column, $label, $exporter);
  }

  public static function belongsTo(string $relationship, string $label, string $internalName = null, string $valueField = 'id', string $nameField = 'name'): static
  {
    $exporter = new BelongsToExport($valueField, $nameField);

    $internalName ??= "{$relationship}_id";

    return new static($relationship, $label, $exporter, $internalName);
  }

  /**
   * Create a new morph to export.
   *
   * @param string $column
   * @param string $label
   */
  public static function morphTo(string $relationship, string $label, array $types, string $valueField = 'id', string $nameField = 'name'): static
  {
    $morphId ??= "{$relationship}_id";
    $morphType ??= "{$relationship}_type";

    $exporter = new MorphToExport($valueField, $nameField, $morphId, $morphType, $types);

    return new self($relationship, $label, $exporter);
  }

  /**
   * Get the attribute to export.
   *
   * @return string
   */
  public function getAttribute(): string
  {
    return $this->attribute;
  }

  /**
   * Get the internal name for the attribute.
   *
   * @return string
   */
  public function getInternalName(): string
  {
    return $this->internalName;
  }

  /**
   * Get the attribute label.
   *
   * @return string
   */
  public function getLabel(): string
  {
    return $this->label;
  }

  public function getValue($model): mixed
  {
    return ($this->exporter)($model, $this->attribute);
  }
}
