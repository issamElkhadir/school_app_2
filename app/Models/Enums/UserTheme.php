<?php

namespace App\Models\Enums;

enum UserTheme: string
{
  case LIGHT = 'light';

  case DARK = 'dark';

  case AUTO = 'auto';

  public function label(): string
  {
    return match ($this) {
      self::LIGHT => 'Light',
      self::DARK => 'Dark',
      self::AUTO => 'Auto',
    };
  }

  public function toArray()
  {
    return [
      'value' => $this->value,
      'label' => $this->label(),
    ];
  }
}
