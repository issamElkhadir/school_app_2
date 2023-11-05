<?php

namespace App\Traits;

use App\Models\Scopes\ArchivedScope;
use App\Models\Scopes\SoftDeleteScope;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 *
 * @method static Builder|\Illuminate\Database\Query\Builder withArchived(bool $withArchived = true)
 * @method static Builder|\Illuminate\Database\Query\Builder onlyArchived()
 * @method static Builder|\Illuminate\Database\Query\Builder withoutArchived()
 * @method static Builder|\Illuminate\Database\Query\Builder onlyTrashed()
 * @method static Builder|\Illuminate\Database\Query\Builder withTrashed(bool $withArchived = true)
 * @method static Builder|\Illuminate\Database\Query\Builder withoutTrashed()
 */
trait Trackable
{
  /**
   * @return void
   */
  public static function bootTrackable(): void
  {
    static::addGlobalScope(new ArchivedScope());
    static::addGlobalScope(new SoftDeleteScope());

    // Associate createdBy relationship and createdDate before creating
    self::creating(function (self $model) {
      $model->setCreatedBy();
    });

    // Associate updatedBy relationship and updatedDate before updating
    self::updating(function (self $model) {
      $model->setUpdatedBy();
    });
  }

  /**
   * Fill the createdBy relationship
   *
   *
   * @return static
   */
  public function setCreatedBy(): static
  {
    $this->createdBy()->associate(auth()->user() ?? 1);

    return $this;
  }

  /**
   * Fill the updatedBy relationship
   *
   * @param self $model
   *
   * @return static
   */
  public function setUpdatedBy(): static
  {
    $relationship = $this->updatedBy();

    // Check if updatedBy returns an instance of BelongsTo
    $relationship->associate(auth()->user() ?? 1);

    return $this;
  }

  /**
   * createdBy relationship for retrieving the user who made the creation action.
   *
   * @return BelongsTo
   */
  public function createdBy(): BelongsTo
  {
    return $this->belongsTo(User::class, 'created_by');
  }

  /**
   * updatedBy relationship for retrieving the user who made the update action.
   *
   * @return BelongsTo
   */
  public function updatedBy(): BelongsTo
  {
    return $this->belongsTo(User::class, 'updated_by');
  }

  /**
   * deletedBy relationship for retrieving the user who made the update action.
   *
   * @return BelongsTo
   */
  public function deletedBy(): BelongsTo
  {
    return $this->belongsTo(User::class, 'deleted_by');
  }

  // archivedBy relationship for retrieving the user who made the archive action.
  public function archivedBy(): BelongsTo
  {
    return $this->belongsTo(User::class, 'archived_by');
  }

  /**
   * Get the name of the "archived at" column.
   *
   * @return string
   */
  public function getArchivedAtColumn(): string
  {
    return defined(static::class . '::ARCHIVED_AT') ? static::ARCHIVED_AT : 'archived_at';
  }

  /**
   * Get the name of the "trashed at" column.
   *
   * @return string
   */
  public function getTrashedAtColumn(): string
  {
    return defined(static::class . '::TRASHED_AT') ? static::TRASHED_AT : 'trashed_at';
  }

  /**
   * Get the name of the "archived automatic" column.
   *
   * @return string
   */
  public function getAutomaticArchivedColumn(): string
  {
    return defined(static::class . '::AUTOMATIC_ARCHIVED') ? static::AUTOMATIC_ARCHIVED : 'archived_automatic';
  }

  /**
   * Get the name of the "archived by" column.
   *
   * @return string
   */
  public function getArchivedByColumn(): string
  {
    return defined(static::class . '::ARCHIVED_BY') ? static::ARCHIVED_BY : 'archived_by';
  }

  /**
   * Get the fully qualified "archived at" column.
   *
   * @return string
   */
  public function getQualifiedArchivedAtColumn(): string
  {
    return $this->qualifyColumn($this->getArchivedAtColumn());
  }

  /**
   * Get the fully qualified "archived at" column.
   *
   * @return string
   */
  public function getQualifiedArchivedByColumn(): string
  {
    return $this->qualifyColumn($this->getArchivedAtColumn());
  }

  /**
   * Get the fully qualified "deleted at" column.
   *
   * @return string
   */
  public function getDeletedAtColumn(): string
  {
    return defined(static::class . '::DELETED_AT') ? static::DELETED_AT : 'deleted_at';
  }

  /**
   * Get the fully qualified "deleted at" column.
   *
   * @return string
   */
  public function getQualifiedDeletedAtColumn(): string
  {
    return $this->qualifyColumn($this->getDeletedAtColumn());
  }

  /**
   * Get the fully qualified "deleted by" column.
   *
   * @return string
   */
  public function getDeletedByColumn(): string
  {
    return defined(static::class . '::DELETED_BY') ? static::DELETED_BY : 'deleted_by';
  }

  /**
   * Get the fully qualified "deleted by" column.
   *
   * @return string
   */
  public function getQualifiedDeletedByColumn(): string
  {
    return $this->qualifyColumn($this->getDeletedByColumn());
  }

  /**
   * Determine if the model instance has been archived.
   *
   * @return bool
   */
  public function archived(): bool
  {
    return !is_null($this->{$this->getArchivedAtColumn()});
  }

  /**
   * Determine if the model instance has been trashed.
   *
   * @return bool
   */
  public function trashed(): bool
  {
    return !is_null($this->{$this->getTrashedAtColumn()});
  }
}
