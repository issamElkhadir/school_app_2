<?php

namespace App\Exports\FieldsExport;

class MorphToExport implements ExportInterface
{
  /**
   * The name field to export.
   *
   * @var string
   */
  protected string $nameField = 'name';

  /**
   * The value field to export.
   *
   * @var string
   */
  protected string $valueField = 'id';

  /**
   * The morph id field to export.
   *
   * @var string
   */
  protected string $morphId;

  /**
   * The morph type field to export.
   *
   * @var string
   */
  protected string $morphType;

  /**
   * The morph types to export.
   *
   * @var array
   */
  protected array $types;

  public function __construct(string $valueField = 'id', string $nameField = 'name', string $morphId = null, string $morphType = null, array $types = [])
  {
    $this->nameField = $nameField;
    $this->valueField = $valueField;
    $this->morphId = $morphId;
    $this->morphType = $morphType;
    $this->types = $types;
  }

  public function __invoke($model, string $attribute): mixed
  {
    if (!$model->relationLoaded($attribute) || $model->{$attribute} === null) {
      return null;
    }

    $type = $this->types[$model->{$this->morphType}] ?? null;

    if ($type === null) {
      return null;
    }

    $value = $model->{$attribute}->{$this->valueField};

    $name = $model->{$attribute}->{$this->nameField};

    return "$value / $type / $name";
  }
}
