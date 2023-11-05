<?php

namespace Tests\Feature\Models;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CityTest extends TestCase
{
  use RefreshDatabase;

  public function setUp(): void
  {
    parent::setUp();

    $this->setUpUser(['base.city.*']);
  }

  /** @test */
  public function it_can_create_a_city()
  {
    $payload = City::factory()->makeOne()->toArray();

    $payload['country'] = Country::factory()->create()->only(['id', 'name']);

    $payload['state'] = State::factory()->create()->only(['id', 'name']);

    $response = $this->postJson(route('api.cities.store'), $payload);

    $response->assertStatus(201)
      ->assertJson(['data' => ['name' => $payload['name']]]);

    $this->assertDatabaseHas('cities', ['name' => $payload['name']]);
  }

  /** @test */
  public function it_can_get_a_city_by_id()
  {
    $city = City::factory()->create();

    $response = $this->getJson(route('api.cities.show', $city->id));

    $response->assertStatus(200);

    $response->assertJson(['data' => ['name' => $city->name]]);
  }

  /** @test */
  public function it_can_update_a_city()
  {
    $city = City::factory()->create();

    $city->name = 'Updated';

    $payload = $city->toArray();

    $response = $this->putJson(route('api.cities.update', $city->id), $payload);

    $response->assertStatus(200)
      ->assertJson(['data' => ['name' => 'Updated']]);

    $this->assertDatabaseHas('cities', ['id' => $city->id, 'name' => $payload['name']]);
  }

  /** @test */
  public function it_can_delete_a_city()
  {
    $city = City::factory()->create();

    $response = $this->deleteJson(route('api.cities.destroy', $city->id));

    $response->assertStatus(200);

    $this->assertDatabaseMissing($city, ['id' => $city->id]);
  }

  /** @test */
  public function it_can_list_cities()
  {
    $cities = City::factory()->count(5)->create();

    $response = $this->getJson(route('api.cities.index'));

    $response->assertStatus(200)
      ->assertJsonCount($cities->count(), 'data');
  }
}
