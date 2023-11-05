<?php

namespace Modules\Education\Tests\Feature;

use Modules\Education\Entities\EventCategory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EventCategoryTest extends TestCase
{
  use RefreshDatabase;

  public function setUp(): void
  {
    parent::setUp();

    $this->setUpUser(['education.event-categories.*']);
  }

  /** @test */
  public function can_get_all_event_categories()
  {
    EventCategory::factory()->count(5)->create();

    $response = $this->getJson(route('api.education.event-categories.index'));

    $response->assertOk()
      ->assertJsonCount(5, 'data')
      ->assertJsonStructure([
        'data' => [
          '*' => [
            'id',
            'name',
            'type',
            'icon'
          ]
        ]
      ]);
  }

  /** @test */
  public function can_store_event_category()
  {
    $category = EventCategory::factory()
      ->makeOne()
      ->only(['name', 'type', 'icon']);

    $response = $this->postJson(route('api.education.event-categories.store', $category));

    $response->assertCreated();

    $this->assertDatabaseHas(EventCategory::class, $category);
  }
}
