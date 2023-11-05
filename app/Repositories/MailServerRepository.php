<?php

namespace App\Repositories;

use App\Filters\BooleanFilter;
use App\Models\MailServer;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

/**
 * @template T of \App\Models\MailServer
 */
class MailServerRepository extends BaseRepository
{
  public function model()
  {
    return MailServer::class;
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
      "priority",
      "active",
      "username",
      "smtp_host",
      "smtp_port",
      "smtp_encryption",
    ];
  }

  public function allowedSorts(): array
  {
    return [
      AllowedSort::field('id'),
      AllowedSort::field('name'),
      AllowedSort::field('priority'),
      AllowedSort::field('active'),
      AllowedSort::field('username'),
      AllowedSort::field('smtp_host'),
      AllowedSort::field('smtp_port'),
      AllowedSort::field('smtp_encryption'),
    ];
  }

  public function allowedFilters(): array
  {
    return [
      AllowedFilter::exact('id'),
      AllowedFilter::partial('name'),
      AllowedFilter::exact('priority'),
      AllowedFilter::custom('active', BooleanFilter::make()),
      AllowedFilter::partial('username'),
      AllowedFilter::partial('smtp_host'),
      AllowedFilter::exact('smtp_port'),
      AllowedFilter::partial('smtp_encryption'),
    ];
  }

  public function searchFields(): array
  {
    return ['name', 'username', 'smtp_host', 'smtp_encryption'];
  }
}
