<?php

namespace App\Notifications;

enum NotificationStatus: string
{
  case INFO = 'info';

  case SUCCESS = 'success';

  case WARN = 'warn';

  case ERROR = 'error';
}
