<?php

namespace App\Notifications;

use App\Models\Notification;
use Illuminate\Notifications\Notifiable as BaseNotification;

trait Notifiable
{
  use BaseNotification;

  /**
   * Get the entity's notifications.
   */
  public function notifications()
  {
    return $this->morphMany(Notification::class, 'notifiable')
      ->orderBy('created_at', 'desc');
  }
}
