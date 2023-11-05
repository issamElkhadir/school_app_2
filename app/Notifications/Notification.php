<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Support\Arrayable;
use \Illuminate\Notifications\Notification as LaravelNotification;

class Notification extends LaravelNotification implements Arrayable, ShouldQueue
{
  use Queueable;

  /**
   * The notification's title.
   *
   * @var string
   */
  protected string $title;

  /**
   * The notification's body.
   *
   * @var string|null
   */
  protected string|null $body;

  /**
   * The notification's icon.
   *
   * @var string|null
   */
  protected string|null $icon = null;

  /**
   * The notification's icon color.
   *
   * @var string|null
   */
  protected string|null $iconColor = null;

  /**
   * The notification's status.
   *
   * @var NotificationStatus|null
   */
  protected NotificationStatus|null $status = NotificationStatus::INFO;

  /**
   * The notification's duration.
   *
   * @var int
   */
  protected int $duration = 5000;

  /**
   * The notification's position.
   *
   * @var string
   */
  protected NotificationPosition $position = NotificationPosition::BOTTOM_RIGHT;

  /**
   * The notification's dismissible.
   *
   * @var bool
   */
  protected bool $dismissible = true;

  /**
   * The notification's actions.
   *
   * @var array<int, NotificationAction>
   */
  protected array $actions = [];

  /**
   * Set the notification title
   *
   * @param string $title
   * @return static
   */
  public function title(string $title): static
  {
    $this->title = $title;

    return $this;
  }

  /**
   * Set the notification body
   *
   * @param string $body
   * @return static
   */
  public function body(string $body): static
  {
    $this->body = $body;

    return $this;
  }

  /**
   * Set the notification icon
   *
   * @param string $icon
   * @return static
   */
  public function icon(string $icon): static
  {
    $this->icon = $icon;

    return $this;
  }

  /**
   * Set the notification icon color
   *
   * @param string $iconColor
   * @return static
   */
  public function iconColor(string $iconColor): static
  {
    $this->iconColor = $iconColor;

    return $this;
  }

  /**
   * Set the notification status
   *
   * @param NotificationStatus $status
   * @return static
   */
  public function status(NotificationStatus $status): static
  {
    $this->status = $status;

    return $this;
  }

  /**
   * Set the notification status with success
   *
   * @return static
   */
  public function success(): static
  {
    return $this->status(NotificationStatus::SUCCESS);
  }

  /**
   * Set the notification status with info
   *
   * @return static
   */
  public function info(): static
  {
    return $this->status(NotificationStatus::INFO);
  }

  /**
   * Set the notification status with warn
   *
   * @return static
   */
  public function warn(): static
  {
    return $this->status(NotificationStatus::WARN);
  }

  /**
   * Set the notification status with error
   *
   * @return static
   */
  public function error(): static
  {
    return $this->status(NotificationStatus::ERROR);
  }

  /**
   * Set the notification duration
   *
   * @param int $duration
   * @return static
   */
  public function duration(int $duration): static
  {
    $this->duration = $duration;

    return $this;
  }

  /**
   * Set the notification with seconds duration
   *
   * @param int $seconds
   * @return static
   */
  public function seconds(int $seconds): static
  {
    return $this->duration($seconds * 1000);
  }

  /**
   * Set the notification position
   *
   * @param NotificationPosition $position
   * @return static
   */
  public function position(NotificationPosition $position): static
  {
    $this->position = $position;

    return $this;
  }

  /**
   * Set the notification persistent
   *
   * @param bool $persistent
   * @return static
   */
  public function persistent(bool $persistent = true): static
  {
    $this->dismissible = !$persistent;

    return $this;
  }

  /**
   * Set the notification dismissible
   *
   * @param bool $dismissible
   * @return static
   */
  public function dismissible(bool $dismissible = true): static
  {
    $this->dismissible = $dismissible;

    return $this;
  }

  /**
   * Set the notification actions
   *
   * @param array<int, NotificationAction> $actions
   * @return static
   */
  public function actions(array $actions): static
  {
    $this->actions = $actions;

    return $this;
  }

  /**
   * Get the notification channels.
   *
   * @param  mixed  $notifiable
   * @return array|string
   */
  public function via($notifiable)
  {
    return [NotificationChannel::class];
  }

  public static function make(): static
  {
    return new self();
  }

  /**
   * Get the notification as an array
   *
   * @return array
   */
  public function toArray(): array
  {
    return [
      'title' => $this->title,
      'body' => $this->body,
      'icon' => $this->icon,
      'iconColor' => $this->iconColor,
      'status' => $this->status,
      'duration' => $this->duration,
      'position' => $this->position,
      'dismissible' => $this->dismissible,
      'actions' => array_map(fn(NotificationAction $action): array => $action->toArray(), $this->actions),
    ];
  }
}
