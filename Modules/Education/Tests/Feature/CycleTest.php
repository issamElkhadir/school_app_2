<?php

namespace Modules\Education\Tests\Feature;

use App\Models\City;
use App\Models\Country;
use Modules\Education\Entities\Cycle;
use App\Models\School;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CycleTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function setUp(): void
  {
    parent::setUp();

    $this->setUpUser(['education.cycle.*']);
  }

  /** @test */
  public function can_get_cycles()
  {
    Cycle::factory()->count(5)->create();

    $response = $this->get(route('api.education.cycles.index'));

    $response->assertSuccessful()
      ->assertJsonCount(5, 'data');

  }

  /** @test */
  public function can_create_cycle()
  {
    $cycle = Cycle::factory()->makeOne()->toArray();

    $schools = School::factory()->count(5)->create();

    $cycle['schools'] = $schools->map->only(['id'])->toArray();

    $response = $this->post(route('api.education.cycles.store'), $cycle);

    $response->assertStatus(201);

    $this->assertDatabaseHas('cycles', [
      'name' => $cycle['name'],
    ]);
  }

  /** @test */
  public function can_update_cycle()
  {
    $cycle = Cycle::factory()->create();

    $schools = School::factory()->count(5)->create();

    $cycle['schools'] = $schools->map->only(['id'])->toArray();

    $cycle->name = $this->faker->name();

    $response = $this->put(route('api.education.cycles.update', $cycle->id), $cycle->toArray());

    $response->assertStatus(200);

    $this->assertDatabaseHas('cycles', [
      'name' => $cycle->name
    ]);
  }

  /** @test */
  public function can_delete_cycle()
  {
    $cycle = Cycle::factory()->create();

    $response = $this->delete(route('api.education.cycles.destroy', $cycle->id));

    $response->assertStatus(200);

    $this->assertDatabaseMissing('cycles', [
      'id' => $cycle->id
    ]);
  }

  /** @test */
  public function can_show_cycle()
  {
    $cycle = Cycle::factory()->create();

    $response = $this->get(route('api.education.cycles.show', $cycle->id));

    $response->assertStatus(200);

    $this->assertEquals($cycle->name, $response->json('data.name'));
  }
}
