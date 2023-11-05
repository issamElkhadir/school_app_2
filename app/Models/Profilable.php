<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\MorphOne;

interface Profilable
{
  /**
   * Get the user associated with the model.
   *
   * @return MorphOne
   */
  public function user(): MorphOne;

  /**
   * Get the instance as an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(): array;
}
