<?php

namespace Tests\Feature\Models;

use App\Models\Country;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CountriesTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function setUp(): void
  {
    parent::setUp();

    $this->setUpUser(['base.country.*']);
  }

  /** @test */
  public function it_can_create_a_country()
  {
    $payload = Country::factory()->make()->toArray();

    $response = $this->postJson(route('api.countries.store'), $payload);

    $response->assertStatus(201)
      ->assertJson(['data' => ['name' => $payload['name']]]);

    $this->assertDatabaseHas('countries', ['name' => $payload['name']]);
  }

  /** @test */
  public function it_can_get_a_country_by_id()
  {
    $country = Country::factory()->create();

    $response = $this->getJson(route('api.countries.show', $country->id));

    $response->assertStatus(200);

    $response->assertJson(['data' => ['name' => $country->name]]);
  }

  /** @test */
  public function it_can_update_a_country()
  {
    $country = Country::factory()->create();

    $country->name = 'Updated';

    $payload = $country->toArray();

    $response = $this->putJson(route('api.countries.update', $country->id), $payload);

    $response->assertStatus(200)
      ->assertJson(['data' => ['name' => 'Updated']]);

    $this->assertDatabaseHas('countries', ['id' => $country->id, 'name' => $payload['name']]);
  }

  /** @test */
  public function it_can_delete_a_country()
  {
    $country = Country::factory()->create();

    $response = $this->deleteJson(route('api.countries.destroy', $country->id));

    $response->assertStatus(200);

    $this->assertDatabaseMissing('countries', ['id' => $country->id]);
  }

  /** @test */
  public function it_can_list_countries()
  {
    $countries = Country::factory()->count(5)->create();

    $response = $this->getJson(route('api.countries.index'));

    $response->assertStatus(200)
      ->assertJson(['data' => [['name' => $countries[0]->name]]]);
  }

  /** @test */
  public function it_can_paginate_countries()
  {
    $countries = Country::factory()->count(5)->create();

    $response = $this->getJson(route('api.countries.index', [
      config('platform.paginator.per_page') => 2,
      config('platform.paginator.page') => 2
    ]));

    $response->assertStatus(200)
      ->assertJson(['data' => [['name' => $countries[2]->name], ['name' => $countries[3]->name]]]);
  }

  /** @test */
  public function it_can_search_countries_by_name()
  {
    $countries = Country::factory()->count(5)->create();

    $response = $this->getJson(route('api.countries.index', [
      'search' => $countries[0]->name
    ]));

    $response->assertStatus(200)
      ->assertJson(['data' => [['name' => $countries[0]->name]]]);
  }
}
