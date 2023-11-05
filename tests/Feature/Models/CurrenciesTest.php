<?php

namespace Tests\Feature\Models;

use App\Models\Currency;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CurrenciesTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function setUp(): void
  {
    parent::setUp();

    $this->setUpUser(['base.currency.*']);
  }

  /** @test */
  public function it_can_create_a_currency()
  {
    $payload = Currency::factory()->make()->toArray();

    $response = $this->postJson(route('api.currencies.store'), $payload);

    $response->assertStatus(201)
      ->assertJson(['data' => ['name' => $payload['name']]]);

    $this->assertDatabaseHas('currencies', ['name' => $payload['name']]);
  }

  /** @test */
  public function it_can_get_a_currency_by_id()
  {
    $currency = Currency::factory()->create();

    $response = $this->getJson(route('api.currencies.show', $currency->id));

    $response->assertStatus(200);

    $response->assertJson(['data' => ['name' => $currency->name]]);
  }

  /** @test */
  public function it_can_update_a_currency()
  {
    $curreny = Currency::factory()->create();

    $curreny->name = 'Updated';

    $payload = $curreny->toArray();

    $response = $this->putJson(route('api.currencies.update', $curreny->id), $payload);

    $response->assertStatus(200)
      ->assertJson(['data' => ['name' => 'Updated']]);

    $this->assertDatabaseHas('currencies', ['id' => $curreny->id, 'name' => $payload['name']]);
  }

  /** @test */
  public function it_can_delete_a_currency()
  {
    $currency = Currency::factory()->create();

    $response = $this->deleteJson(route('api.currencies.destroy', $currency->id));

    $response->assertStatus(204);

    $this->assertDatabaseMissing('currencies', ['id' => $currency->id]);
  }

  /** @test */
  public function it_can_list_currencies()
  {
    $currencies = Currency::factory()->count(5)->create();

    $response = $this->getJson(route('api.currencies.index'));

    $response->assertStatus(200)
      ->assertJson(['data' => [['name' => $currencies[0]->name]]]);
  }

  /** @test */
  public function it_can_paginate_currencies()
  {
    $currencies = Currency::factory()->count(5)->create();

    $response = $this->getJson(route('api.currencies.index', [
      config('platform.paginator.per_page') => 2,
      config('platform.paginator.page') => 2
    ]));

    $response->assertStatus(200)
      ->assertJson(['data' => [['name' => $currencies[2]->name], ['name' => $currencies[3]->name]]]);
  }

  /** @test */
  public function it_can_search_currencies_by_name()
  {
    $currencies = Currency::factory()->count(5)->create();

    $response = $this->getJson(route('api.currencies.index', [
      'search' => $currencies[0]->name
    ]));

    $response->assertStatus(200)
      ->assertJson(['data' => [['name' => $currencies[0]->name]]]);
  }
}
