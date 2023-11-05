<?php

namespace Modules\Education\Tests\Feature;

use Modules\Education\Entities\Period;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PeriodTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function setUp(): void
  {
    parent::setUp();

    $this->setUpUser(['education.period.*']);
  }

  /** @test */
  public function can_get_periods()
  {
    Period::factory()->count(5)->create();

    $response = $this->get(route('api.education.periods.index'));

    $response->assertSuccessful()
      ->assertJsonCount(5, 'data');

  }

  /** @test */
  public function can_create_period()
  {
    $period = Period::factory()->makeOne()->toArray();

    $response = $this->post(route('api.education.periods.store'), $period);

    $response->assertStatus(201);

    $this->assertDatabaseHas('periods', [
      'name' => $period['name'],
    ]);
  }

  /** @test */
  public function can_update_period()
  {
    $period = Period::factory()->create();

    $period->name = $this->faker->name();

    $response = $this->put(route('api.education.periods.update', $period->id), $period->toArray());

    $response->assertStatus(200);

    $this->assertDatabaseHas('periods', [
      'name' => $period->name
    ]);
  }

  /** @test */
  public function can_delete_period()
  {
    $period = Period::factory()->create();

    $response = $this->delete(route('api.education.periods.destroy', $period->id));

    $response->assertStatus(200);

    $this->assertDatabaseMissing('periods', [
      'id' => $period->id
    ]);
  }

  /** @test */
  public function can_show_period()
  {

    $period = Period::factory()->create();

    $response = $this->get(route('api.education.periods.show', $period->id));

    $response->assertStatus(200);

    $this->assertEquals($period->name, $response->json('data.name'));
  }
}
