<?php

namespace App\Notifications;

use App\Models\Notification;
use Illuminate\Notifications\Notification as LaravelNotification;
use Illuminate\Support\Str;

class NotificationChannel
{
  /**
   * Send channel notification.
   *
   * @param  mixed  $notifiable
   * @param  \Illuminate\Notifications\Notification  $notification
   * @return void
   */
  public function send($notifiable, LaravelNotification $notification)
  {
    Notification::create([
      'id' => Str::orderedUuid(),
      'type' => get_class($notification),
      'notifiable_id' => $notifiable->getKey(),
      'notifiable_type' => $notifiable->getMorphClass(),
      'data' => $notification->toArray($notifiable),
    ]);
  }
}
