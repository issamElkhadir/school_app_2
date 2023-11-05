<?php

namespace Modules\Education\Repositories;

use App\Repositories\BaseRepository;
use Modules\Education\Entities\EventCategory;

class EventCategoryRepository extends BaseRepository
{
  public function model()
  {
    return EventCategory::class;
  }

  public function allowedFields(): array
  {
    return [
      'id',
      'name',
      'type',
      'icon',
    ];
  }
}
