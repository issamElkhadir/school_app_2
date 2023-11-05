<?php

namespace App\Notifications;

use Illuminate\Contracts\Support\Arrayable;

class NotificationAction implements Arrayable
{
  protected array $props = [];

  /**
   * The action's label.
   *
   * @var string
   */
  protected string $label;

  /**
   * Make the action as a button.
   *
   * @var bool
   */
  protected bool $asButton = false;

  /**
   * The action's color.
   *
   * @var string|null
   */
  protected string|null $color = null;

  /**
   * The action's icon.
   *
   * @var string|null
   */
  protected string|null $icon = null;

  /**
   * The action's url.
   *
   * @var string|null
   */
  protected string|null $url = null;

  /**
   * Open the action's url in a new tab.
   *
   * @var bool
   */
  protected bool $newTab = false;

  /**
   * Should the action close notification
   *
   * @var bool
   */
  protected bool $shouldCloseNotification = false;

  /**
   * Mark the action as read.
   *
   * @var bool
   */
  protected bool $markAsRead = false;

  /**
   * Create a new action instance.
   *
   * @param string $label
   */
  public function __construct(string $label)
  {
    $this->label = $label;
  }

  /**
   * Make the action as a button.
   *
   * @param bool $asButton
   * @return static
   */
  public function button(bool $asButton = true): static
  {
    $this->asButton = $asButton;

    return $this;
  }

  /**
   * Set the action's color.
   *
   * @param string $color
   * @return static
   */
  public function color(string $color): static
  {
    $this->color = $color;

    return $this;
  }

  /**
   * Set the action's icon.
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
   * Set the action's url.
   *
   * @param string $url
   * @return static
   */
  public function url(string $url): static
  {
    $this->url = $url;

    $this->props['href'] = $url;

    return $this;
  }

  /**
   * Open the action's url in a new tab.
   *
   * @param bool $newTab
   * @return static
   */
  public function openInNewTab(bool $newTab = true): static
  {
    $this->newTab = $newTab;

    return $this;
  }

  /**
   * Set the action to close the notification on click
   *
   * @param bool $shouldCloseNotification
   * @return static
   */
  public function close(bool $shouldCloseNotification = true): static
  {
    $this->shouldCloseNotification = $shouldCloseNotification;

    return $this;
  }

  /**
   * Set the action to mark the notification as read on click
   *
   * @param bool $markAsRead
   * @return static
   */
  public function markAsRead(bool $markAsRead = true): static
  {
    $this->markAsRead = $markAsRead;

    return $this;
  }

  public static function make(string $label): static
  {
    return new static($label);
  }

  /**
   * Convert the action to an array.
   *
   * @return array
   */
  public function toArray(): array
  {
    return [
      'label' => $this->label,
      'asButton' => $this->asButton,
      'color' => $this->color,
      'icon' => $this->icon,
      'url' => $this->url,
      'newTab' => $this->newTab,
      'shouldCloseNotification' => $this->shouldCloseNotification,
      'props' => $this->props,
      'markAsRead' => $this->markAsRead,
    ];
  }
}
