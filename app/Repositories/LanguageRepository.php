<?php

namespace App\Repositories;

use App\Models\Language;

/**
 * @template T of \App\Models\Language
 */
class LanguageRepository extends BaseRepository
{
  public function model()
  {
    return Language::class;
  }

  public function allowedIncludes(): array
  {
    return [];
  }

  public function allowedFields(): array
  {
    return [
      "id",
      "name",
      "has_translation",
      "direction",
      "local_code",
      "iso_code",
      "url_code",
      "status",
      "created_at",
      "updated_at"
    ];
  }

  public function allowedSorts(): array
  {
    return [];
  }

  public function searchFields(): array
  {
    return ['name'];
  }
}
