<?php

namespace App\Notifications;

enum NotificationPosition: string
{
  case TOP_RIGHT = 'top-right';

  case TOP_LEFT = 'top-left';

  case BOTTOM_RIGHT = 'bottom-right';

  case BOTTOM_LEFT = 'bottom-left';

  case TOP_CENTER = 'top-center';

  case BOTTOM_CENTER = 'bottom-center';

  case CENTER = 'center';
}
