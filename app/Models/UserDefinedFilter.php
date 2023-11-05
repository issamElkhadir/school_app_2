<?php

namespace App\Models;

use App\Traits\Trackable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDefinedFilter extends Model
{
  use HasFactory, Trackable;

  protected $guarded = [];

  protected $casts = [
    'is_default' => 'boolean',
    'is_enabled' => 'boolean',
    'filters' => 'json',
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }
}
