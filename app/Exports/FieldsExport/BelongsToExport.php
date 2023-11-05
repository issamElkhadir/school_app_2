<?php

namespace App\Exports\FieldsExport;

class BelongsToExport implements ExportInterface
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

  public function __construct(string $valueField = 'id', string $nameField = 'name')
  {
    $this->nameField = $nameField;
    $this->valueField = $valueField;
  }

  public function __invoke($model, string $attribute): mixed
  {
    if (!$model->relationLoaded($attribute) || $model->{$attribute} === null) {
      return null;
    }

    $value = $model->{$attribute}->{$this->valueField};

    $name = $model->{$attribute}->{$this->nameField};

    return "$value / $name";
  }
}
