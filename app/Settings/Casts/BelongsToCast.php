<?php

namespace App\Settings\Casts;

use Spatie\LaravelSettings\SettingsCasts\SettingsCast;

class BelongsToCast implements SettingsCast
{
  protected string $class;

  protected array $fields;

  public function __construct(string $class, array $fields = null)
  {
    $this->class = $class;

    $fields ??= ['id', 'name'];

    $this->fields = $fields;
  }

  /**
   * Will be used to when retrieving a value from the repository, and
   * inserting it into the settings class.
   */
  public function get($payload)
  {
    if (is_null($payload)) {
      return null;
    }

    return $this->class::find($payload['id'], $this->fields);
  }

  /**
   * Will be used to when retrieving a value from the settings class, and
   * inserting it into the repository.
   */
  public function set($payload)
  {
    if (is_array($payload)) {
      return $payload;
    }

    if (is_null($payload)) {
      return null;
    }

    if (!is_object($payload)) {
      throw new \Exception('BelongsToCast can only cast objects');
    }

    // Set only id, name
    return $payload->only(['id', 'name']);
  }
}
