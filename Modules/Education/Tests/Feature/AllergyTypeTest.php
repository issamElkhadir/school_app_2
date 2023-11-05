<?php

namespace Modules\Education\Tests\Feature;

use App\Models\School;
use Modules\Education\Entities\AllergyType;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AllergyTypeTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function setUp(): void
  {
    parent::setUp();

    $this->setUpUser(['education.allergy-type.*']);
  }

  /** @test */
  public function can_get_allergy_types()
  {

    $allergyType = AllergyType::factory()->count(5);

    $school = School::factory()->create();

    $allergyType->create([
      'school_id' => $school->id,
    ]);

    $response = $this->get(route('api.education.allergy-types.index'));

    $response->assertSuccessful()
      ->assertJsonCount(5, 'data');

  }

  /** @test */
  public function can_create_allergy_type()
  {
    $allergyType = AllergyType::factory()->makeOne()->toArray();

    $school = School::factory()->create();

    $allergyType['school'] = $school->only('id', 'name');

    $response = $this->post(route('api.education.allergy-types.store'), $allergyType);

    $response->assertStatus(201);

    $this->assertDatabaseHas('allergy_types', [
      'name' => $allergyType['name'],
    ]);
  }

  /** @test */
  public function can_update_allergy_type()
  {
    $school = School::factory()->create();

    $allergyType = AllergyType::factory()->create();

    $allergyType->school=$school->only("id","name");

    // Clone the $allergyType instance for the update
    $updatedAllergyType = clone $allergyType;

    $updatedAllergyType->name = $this->faker->name();

    $response = $this->put(route('api.education.allergy-types.update', $allergyType->id), $updatedAllergyType->toArray());

    $response->assertStatus(200);

    $this->assertDatabaseHas('allergy_types', [
        'id' => $allergyType->id, // Ensure the original ID is preserved
        'name' => $updatedAllergyType->name, // Check the updated name
    ]);

  }

  /** @test */
  public function can_delete_allergy_type()
  {
    $allergyType = AllergyType::factory()->create();

    $response = $this->delete(route('api.education.allergy-types.destroy', $allergyType->id));

    $response->assertStatus(200);

    $this->assertDatabaseMissing('allergy_types', [
      'id' => $allergyType->id
    ]);
  }

  /** @test */
  public function can_show_allergy_type()
  {
    $allergyType = AllergyType::factory()->create();

    $response = $this->get(route('api.education.allergy-types.show', $allergyType->id));

    $response->assertStatus(200);

    $this->assertEquals($allergyType->name, $response->json('data.name'));
  }
}
