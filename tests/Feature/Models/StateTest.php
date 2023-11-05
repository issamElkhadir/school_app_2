<?php

namespace Tests\Feature\Models;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class StateTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function setUp(): void
  {
    parent::setUp();

    $this->setUpUser(['base.state.*']);
  }

  /** @test */
  public function it_can_create_a_state()
  {
    $country = \App\Models\Country::factory()->create();

    $state = [
      'name' => $this->faker->name(),
      'country' => $country->only(['id', 'name']),
      'country_code' => $this->faker->countryCode(),
      'fips_code' => $this->faker->word(),
      'iso2' => $this->faker->languageCode(),
      'type' => $this->faker->word(),
      'latitude' => $this->faker->latitude(),
      'longitude' => $this->faker->longitude(),
      'flag' => $this->faker->boolean(),
      'wikiDataId' => $this->faker->word(),
    ];

    $response = $this->postJson(route('api.states.store'), $state);

    $response->assertStatus(201)
      ->assertJson(['data' => ['name' => $state['name']]]);
  }

  /** @test */
  public function it_can_get_a_state_by_id()
  {
    $country = \App\Models\Country::factory()->create();

    $state = \App\Models\State::factory()
      ->create([
        'country_id' => $country->id,
      ]);

    $response = $this->getJson(route('api.states.show', $state->id));

    $response->assertStatus(200);

    $response->assertJson(['data' => ['name' => $state->name]]);
  }

  /** @test */
  public function it_can_update_a_state()
  {
    $country = \App\Models\Country::factory()->create();

    $state = \App\Models\State::factory()
      ->for($country)
      ->create();

    $state->name = 'Updated';

    $attributes = $state->toArray();

    $attributes['country'] = $country->only(['id', 'name']);

    $response = $this->putJson(route('api.states.update', $state->id), $attributes);

    $response->assertStatus(200);

    $response->assertJson(['data' => ['name' => $state->name]]);
  }

  public function it_can_delete_a_state()
  {
    $country = \App\Models\Country::factory()->create();

    $state = \App\Models\State::factory()
      ->for($country)
      ->create();

    $response = $this->deleteJson(route('api.states.destroy', $state->id));

    $response->assertStatus(204);

    $this->assertDatabaseMissing('states', ['id' => $state->id]);
  }

  /** @test */
  public function it_can_list_states()
  {
    $country = \App\Models\Country::factory()->create();

    $state = \App\Models\State::factory()
      ->for($country)
      ->create();

    $response = $this->getJson(route('api.states.index'));

    $response->assertStatus(200);

    $response->assertJson(['data' => [['name' => $state->name]]]);
  }

  /** @test */
  public function it_can_list_states_with_country()
  {
    $country = \App\Models\Country::factory()->create();

    $state = \App\Models\State::factory()
      ->for($country)
      ->create();

    $response = $this->getJson(route('api.states.index', ['include' => 'country']));

    $response->assertStatus(200);

    $response->assertJson(['data' => [['name' => $state->name, 'country' => $country->only(['id', 'name'])]]]);
  }
}
