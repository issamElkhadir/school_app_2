<?php

namespace Modules\Education\Repositories;

use App\Filters\BooleanFilter;
use App\Repositories\BaseRepository;
use App\Services\SequenceGeneratorService;
use Modules\Education\Entities\Subscription;
use Modules\Education\Settings\GeneralSettings;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * @template T of Subscription
 */
class SubscriptionRepository extends BaseRepository
{
  protected GeneralSettings $settings;
  protected SequenceGeneratorService $generator;
  public function __construct(GeneralSettings $settings, SequenceGeneratorService $generator)
  {
    parent::__construct();
    $this->settings = $settings;
    $this->generator = $generator;
  }

  public function create(array $attributes)
  {
    $attributes['class_id'] = $attributes['class']['id'];
    $attributes['student_id'] = $attributes['student']['id'];
    if (!isset($attributes['sequence'])) {
      if (!$this->settings->subscription_sequence) {
        throw new \Exception("Subscription Sequence is not set");
      }
      $attributes['sequence'] = $this->generator->generate($this->settings->subscription_sequence->code);
    }

    unset($attributes['class'], $attributes['student']);

    return parent::create($attributes);
  }

  public function update($model, array $attributes)
  {
    $attributes['class_id'] = $attributes['class']['id'];
    $attributes['student_id'] = $attributes['student']['id'];

    if (!isset($attributes['sequence'])) {
      if (!$this->settings->subscription_sequence) {
        throw new \Exception("Subscription Sequence is not set");
      }
      $attributes['sequence'] = $this->generator->generate($this->settings->subscription_sequence->code);
    }

    unset($attributes['class'], $attributes['student']);

    return parent::update($model, $attributes);
  }

  public function model()
  {
    return Subscription::class;
  }

  public function allowedIncludes(): array
  {
    return ['class', 'student', 'paymentBill'];
  }

  public function allowedFields(): array
  {
    return [
      "id",
      "class_id",
      "classes.id",
      "classes.name",
      "student_id",
      "students.id",
      "students.name",

      "subscription_date",
      "principal",
      "sequence",

      "created_at",
      "updated_at",
    ];
  }


  public function allowedSorts(): array
  {
    return [
      'id',
      'subscription_date',
      'principal',
      'sequence',
      'created_at',
      'updated_at',
    ];
  }

  public function allowedFilters(): array
  {
    return [
      AllowedFilter::exact('id'),
      AllowedFilter::custom('principal', new BooleanFilter('principal')),
      AllowedFilter::exact('class.id', 'class_id'),
      AllowedFilter::exact('student.id', 'student_id'),
    ];
  }

  public function searchFields(): array
  {
    return [
      'id',
      'name',
    ];
  }

  public function defaultIncludes(): array
  {
    return [
      'class:id,name',
      'student:id,first_name,last_name',
      'paymentBill',
      'paymentBill.currency:id,name',
      'paymentBill.lines',
      'paymentBill.lines.unit:id,name',
      'paymentBill.lines.item',

    ];
  }

}
