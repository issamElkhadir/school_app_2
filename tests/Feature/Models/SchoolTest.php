<?php

namespace Tests\Feature\Models;

use App\Models\City;
use App\Models\Country;
use App\Models\School;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SchoolTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function setUp(): void
  {
    parent::setUp();

    $this->setUpUser(['base.school.*']);
  }

  /** @test */
  public function can_get_schools()
  {
    School::factory()->count(5)->create();

    $response = $this->get(route('api.schools.index'));

    $response->assertSuccessful()
      ->assertJsonCount(5, 'data');
  }

 /** @test */

  public function can_create_school()
  {
    $school = School::factory()->makeOne()->toArray();

    $country = Country::factory()->create();

    $city = City::factory()
      ->create([
        'country_id' => $country->id,
      ]);

    $school['country'] = $country->only('id', 'name');

    $school['city'] = $city->only('id', 'name');

//    $staff = Staff::factory()->count(5)->create();
//
//    $school['staff'] = $staff->pluck('id')->toArray();

    $response = $this->post(route('api.schools.store'), $school);

    $response->assertStatus(201);

    $this->assertDatabaseHas('schools', [
      'name' => $school['name']
    ]);
  }

  /** @test */
  public function can_update_school()
  {
    $school = School::factory()->create();

    $country = Country::factory()->create();

    $city = City::factory()
      ->create([
        'country_id' => $country->id,
      ]);

    $school->country = $country->only('id', 'name');

    $school->city = $city->only('id', 'name');

    $school->name = $this->faker->name();

    $response = $this->put(route('api.schools.update', $school->id), $school->toArray());

    $response->assertStatus(200);

    $this->assertDatabaseHas('schools', [
      'name' => $school->name
    ]);
  }

  /** @test */
  public function can_delete_school()
  {
    $school = School::factory()->create();

    $response = $this->delete(route('api.schools.destroy', $school->id));

    $response->assertStatus(200);

    $this->assertDatabaseMissing('schools', [
      'id' => $school->id
    ]);
  }

  /** @test */
  public function can_show_school()
  {
    $school = School::factory()->create();

    $response = $this->get(route('api.schools.show', $school->id));

    $response->assertStatus(200);

    $this->assertEquals($school->name, $response->json('data.name'));
  }
}
