<?php

namespace Modules\Education\Entities;

use App\Models\Currency;
use App\Traits\Trackable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PackArticle extends Model
{
  use HasFactory, Trackable;

  protected $guarded = [];

  protected static function newFactory()
  {
    return \Modules\Education\Database\factories\PackArticleFactory::new();
  }

  protected $table = "pack_articles";

  public function article(): BelongsTo
  {
    return $this->belongsTo(Article::class);
  }

  public function pack(): BelongsTo
  {
    return $this->belongsTo(Pack::class);
  }

  public function currency(): BelongsTo
  {
    return $this->belongsTo(Currency::class);
  }
}
