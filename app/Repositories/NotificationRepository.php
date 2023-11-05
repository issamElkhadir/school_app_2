<?php

namespace App\Repositories;

use App\Models\Notification;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

/**
 * @template T of \App\Models\Notification
 *
 */
class NotificationRepository extends BaseRepository
{
  public function model()
  {
    return Notification::class;
  }

  public function allowedIncludes(): array
  {
    return [];
  }

  public function allowedFields(): array
  {
    return [
      "id",
    ];
  }

  public function allowedSorts(): array
  {
    return [
      AllowedSort::field('id'),
      AllowedSort::field('created_at'),
    ];
  }

  public function allowedFilters(): array
  {
    return [
      AllowedFilter::exact('id'),
    ];
  }

  public function searchFields(): array
  {
    return [];
  }

  public function read(Notification $notification): Notification
  {
    $notification->markAsRead();

    return $notification;
  }

  public function readAll(): void
  {
    $this
      ->unread()
      ->update([
        'read_at' => now()
      ]);
  }
}
