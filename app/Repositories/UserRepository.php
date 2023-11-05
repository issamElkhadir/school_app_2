<?php

namespace App\Repositories;

use App\Filters\BooleanFilter;
use App\Filters\EnumFilter;
use App\Models\Enums\UserTheme;
use App\Models\User;
use App\Sorts\BelongsToSort;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\Sorts\Sort;

class UserRepository extends BaseRepository
{
  public function model()
  {
    return User::class;
  }

  public function allowedIncludes(): array
  {
    return ['profile', 'language'];
  }

  public function allowedFields(): array
  {
    return [
      'first_name',
      'last_name',
      'email',
      'profile_type',
      'profile_id',
      'profile.created_by',
      'profile.salary',
      'profile.week_hours',
      'profile.id',
      'language_id',
      'language.id',
      'language.name',
    ];
  }

  public function allowedSorts(): array
  {
    return [
      AllowedSort::field('id'),
      AllowedSort::field('first_name'),
      AllowedSort::field('last_name'),
      AllowedSort::field('email'),
      AllowedSort::field('theme'),
      AllowedSort::field('status'),
      AllowedSort::custom('language', new BelongsToSort('language')),
    ];
  }

  public function allowedFilters(): array
  {
    return [
      AllowedFilter::exact('id'),
      AllowedFilter::partial('first_name'),
      AllowedFilter::partial('last_name'),
      AllowedFilter::partial('email'),
      AllowedFilter::custom('status', BooleanFilter::make()),
      AllowedFilter::custom('theme', EnumFilter::make(UserTheme::class)),
      AllowedFilter::exact('language.id', 'language_id'),
    ];
  }

  public function searchFields(): array
  {
    return [
      'id',
      'first_name',
    ];
  }

  public function defaultIncludes(): array
  {
    return ['profile', 'language:id,name'];
  }
}
