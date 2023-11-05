<?php

namespace App\Exports\FieldsExport;

class FieldExport implements ExportInterface
{
  public function __invoke($model, string $attribute): mixed
  {
    return $model->{$attribute};
  }
}
