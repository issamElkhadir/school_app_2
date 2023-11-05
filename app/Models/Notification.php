<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\DatabaseNotification as BaseNotification;

class Notification extends BaseNotification
{
  use SoftDeletes;

  protected $table = 'notifications';

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'data' => 'array',
    'read_at' => 'datetime',
    'received_at' => 'datetime',
    'deleted_at' => 'datetime',
  ];
}
