<?php

namespace App\Repositories;

use App\Models\City;
use App\Models\Translation;
use App\Sorts\BelongsToSort;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

/**
 * @template T of \App\Models\Translation
 */
class TranslationRepository extends BaseRepository
{
  public function create(array $attributes)
  {
    $attributes['language_id'] = $attributes['language']['id'];

    unset($attributes['language']);

    $model = parent::create($attributes);

    $this->cacheLastModified($model->module);

    return $model;
  }

  public function update($model, array $attributes)
  {
    if (isset($attributes['language']['id'])) {
      $attributes['language_id'] = $attributes['language']['id'];
    }

    unset($attributes['language']);

    $model = parent::update($model, $attributes);

    $model->load('language:id,name');

    $this->cacheLastModified($model->module);

    return $model;
  }

  public function delete($model = null): int|bool
  {
    $this->cacheLastModified($model->module);

    return parent::delete($model);
  }

  public function model()
  {
    return Translation::query()->with('language');
  }

  public function allowedIncludes(): array
  {
    return ['language:id,name', 'language'];
  }

  public function allowedFields(): array
  {
    return [
      "id",
      "module",
      "model",
      "value",
      "language_id",
      "languages.name",
      "languages.id",
      "countries.name",
      "created_at",
      "updated_at"
    ];
  }

  public function allowedSorts(): array
  {
    return [
      AllowedSort::field('id'),
      AllowedSort::field('value'),
      AllowedSort::custom('language', new BelongsToSort('language')),
    ];
  }

  public function allowedFilters(): array
  {
    return [
      AllowedFilter::exact('id'),
      AllowedFilter::partial('value'),
      AllowedFilter::partial('model'),
      AllowedFilter::partial('module'),
      AllowedFilter::exact('language', 'language_id'),
    ];
  }

  public function searchFields(): array
  {
    return [
      'values',
    ];
  }

  public function getTranslations(string $module, string $locale)
  {
    // Get all translations for the given module and locale
    $translations = $this->model()
      ->where(function ($query) use ($module) {
        $query->whereNull('module')
          ->orWhere('module', $module);
      })
      ->whereRelation('language', 'local_code', $locale)
      ->get(['key', 'value', 'language_id'])
      ->keyBy('key');

    $fallback = config('app.fallback_locale');

    if ($fallback === $locale) {
      return $translations;
    }

    // Get the fallback
    $fallbackLocale = $this->model()
      ->whereRelation('language', 'local_code', $fallback)
      ->whereNull('module')
      ->get(['key', 'value', 'language_id'])
      ->keyBy('key');

    // Merge keys with fallback
    $fallbackLocale->each(function ($translation, $key) use ($translations) {
      if (!$translations->has($key)) {
        $translations->put($key, $translation);
      }
    });

    return $translations->pluck('value', 'key');
  }

  private function cacheLastModified(?string $module)
  {
    $lastModified = time();

    cache()->forever('translations_last_modified', $lastModified);

    if (!is_null($module)) {
      cache()->forever("translations_{$module}_last_modified", $lastModified);
    }
  }

  public function getLastModified(?string $module)
  {
    if (is_null($module)) {
      return cache('translations_last_modified');
    } else {
      $key1 = "translations_{$module}_last_modified";
      $key2 = 'translations_last_modified';

      $cache1 = cache($key1);
      $cache2 = cache($key2);

      if ($cache1 && $cache2) {
        return max($cache1, $cache2);
      }

      return $cache1 ?? $cache2;
    }
  }
}
