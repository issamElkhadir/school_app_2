<?php

namespace Modules\Education\Tests\Feature;

use App\Models\School;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Education\Entities\VacationType;

class VacationTypeTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function setUp(): void
  {
    parent::setUp();

    $this->setUpUser(['education.vacation-type.*']);
  }

  /** @test */
  public function can_get_vacation_types()
  {
    $school = School::factory()->create();

    $vacationType = VacationType::factory()->count(5);

    $vacationType->create([
      'school_id' => $school->id,
    ]);

    $response = $this->get(route('api.education.vacation-types.index'));

    $response->assertSuccessful()
      ->assertJsonCount(5, 'data');
  }


  /** @test */
  public function can_create_vacation_type()
  {
    $vacationTypeData = VacationType::factory()->makeOne()->toArray();

    $school = School::factory()->create();

    $vacationTypeData['school'] = $school->only('id', 'name');

    $response = $this->post(route('api.education.vacation-types.store'), $vacationTypeData);

    $response->assertSuccessful()
      ->assertJsonStructure(['data' => ['id', 'school']])
      ->assertStatus(201);
  }


  /** @test */
  public function can_update_vacation_type()
  {
    $school = School::factory()->create();

    $vacationType = VacationType::factory()->create([
      'school_id' => $school->id,
    ]);

    $vacationType->school = $school->only('id', 'name');

    $vacationType->name = $this->faker->name();

    $response = $this->putJson(route('api.education.vacation-types.update', $vacationType->id), $vacationType->toArray());

    $response->assertSuccessful()
      ->assertJsonStructure(['data' => ['id', 'school']])
      ->assertStatus(200);;
  }


  /** @test */
  public function can_delete_vacation_type()
  {
    $vacationType = VacationType::factory()->create();

    $response = $this->delete(route('api.education.vacation-types.destroy', $vacationType->id));

    $response->assertStatus(200);

    $this->assertDatabaseMissing('vacation_types', [
      'id' => $vacationType->id
    ]);
  }


  /** @test */
  public function can_show_vacation_type()
  {
    $vacationType = VacationType::factory()->create();

    $response = $this->get(route('api.education.vacation-types.show', $vacationType->id));

    $response->assertSuccessful()
      ->assertJsonStructure(['data' => ['id', 'school']])
      ->assertStatus(200);

    $this->assertEquals($vacationType->id, $response->json('data.id'));

  }
}
