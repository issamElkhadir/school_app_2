<?php

namespace Modules\Education\Tests\Feature;

use App\Models\City;
use App\Models\Country;
use Modules\Education\Entities\Guardian;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GuardianTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function setUp(): void
  {
    parent::setUp();

    $this->setUpUser(['education.guardian.*']);
  }

  /** @test */
  public function can_get_guardians()
  {
    $guardian = Guardian::factory()->count(5);

    $country = Country::factory()->create();
    $city = City::factory()->create([
      'country_id' => $country->id,
    ]);

    $guardian->create([
      'country_id' => $country->id,
      'city_id' => $city->id,
    ]);

    $response = $this->get(route('api.education.guardians.index'));

    $response->assertSuccessful()
      ->assertJsonCount(5, 'data');

  }

  /** @test */
  public function can_create_guardian()
  {
    $guardian = Guardian::factory()->makeOne()->toArray();

    $country = Country::factory()->create();

    $city = City::factory()
      ->create([
        'country_id' => $country->id,
      ]);

    $guardian['country'] = $country->only('id', 'name');

    $guardian['city'] = $city->only('id', 'name');

    $response = $this->post(route('api.education.guardians.store'), $guardian);

    $response->assertStatus(201);

    $this->assertDatabaseHas('guardians', [
      'first_name' => $guardian['first_name'],
      'last_name' => $guardian['last_name']
    ]);
  }

  /** @test */
  public function can_update_guardian()
  {

    $country = Country::factory()->create();

    $city = City::factory()
      ->create([
        'country_id' => $country->id,
      ]);

    $guardian = Guardian::factory()->create([
      'country_id' => $country->id,
      'city_id' => $city->id,
    ]);

    $guardian->country = $country->only('id', 'name');

    $guardian->city = $city->only('id', 'name');

    $guardian->first_name = $this->faker->name();
    $guardian->last_name = $this->faker->name();

    $response = $this->put(route('api.education.guardians.update', $guardian->id), $guardian->toArray());

    $response->assertStatus(200);

    $this->assertDatabaseHas('guardians', [
      'first_name' => $guardian->first_name
    ]);
  }

  /** @test */
  public function can_delete_guardian()
  {
    $country = Country::factory()->create();

    $city = City::factory()->create();

    $guardian = Guardian::factory()->create([
      'country_id' => $country->id,
      'city_id' => $city->id,
    ]);

    $response = $this->delete(route('api.education.guardians.destroy', $guardian->id));

    $response->assertStatus(200);

    $this->assertDatabaseMissing('guardians', [
      'id' => $guardian->id
    ]);
  }

  /** @test */
  public function can_show_guardian()
  {
    $country = Country::factory()->create();

    $city = City::factory()->create();

    $guardian = Guardian::factory()->create([
      'country_id' => $country->id,
      'city_id' => $city->id,
    ]);

    $response = $this->get(route('api.education.guardians.show', $guardian->id));

    $response->assertStatus(200);

    $this->assertEquals($guardian->first_name, $response->json('data.first_name'));
  }
}
