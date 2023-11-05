<?php

namespace App\Exports\FieldsExport;

interface ExportInterface
{
  /**
   * Get the allowed exports.
   *
   * @param \Illuminate\Database\Eloquent\Model $model
   * @param string $attribute
   *
   * @return mixed
   */
  public function __invoke($model, string $attribute): mixed;
}
