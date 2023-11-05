<?php

namespace Modules\Education\Tests\Feature;

use Modules\Education\Entities\AbsenceType;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AbsenceTypeTest extends TestCase
{
  use RefreshDatabase , WithFaker;

  public function setUp(): void
  {
    parent::setUp();

    $this->setUpUser(['education.absence-types.*']);
  }

  /** @test */
  public function can_get_all_available_absence_types()
  {
    AbsenceType::factory()->count(5)->create();

    $this->getJson(route('api.education.absence-types.index'))
      ->assertOk()
      ->assertJsonCount(5, 'data')
      ->assertJsonStructure([
        'data' => [
          '*' => [
            'id',
            'name',
            'rtl_name',
            'status'
          ]
        ]
      ]);
  }

  /** @test */
  public function can_create_absence_type()
  {
    $type = AbsenceType::factory()->makeOne();

    $this->postJson(route('api.education.absence-types.store', $type->toArray()))
      ->assertCreated()
      ->assertJsonStructure([
        'data' => [
          'id',
          'name',
          'rtl_name',
          'status'
        ]
      ]);

    $this->assertDatabaseHas('absence_types', [
      'name' => $type->name,
      'rtl_name' => $type->rtl_name,
    ]);
  }

  /** @test * */
  public function it_can_update_a_absence_type()
  {
    $absenceType = AbsenceType::factory()->create();
    
    $response = $this->put(route('api.education.absence-types.update', $absenceType->id), $absenceType->toArray());

    $response->assertOk('The request to update a absence form failed')
      ->assertSuccessful()
      ->assertJsonStructure(['data' => ['id']]);

    $this->assertDatabaseHas('absence_types', [
      'id' => $absenceType->id,
    ]);
  }

  /** @test * */
  public function it_can_delete_a_absence_type()
  {
    $absenceType = AbsenceType::factory()->create();

    $response = $this->delete(route('api.education.absence-types.destroy', $absenceType->id));

    $response->assertSuccessful()
      ->assertStatus(200);

    $this->assertDatabaseMissing('medical_forms', [
      'id' => $absenceType->id
    ]);
  }

  /** @test * */
  public function it_can_show_absence_type()
  {
    $absenceType = AbsenceType::factory()->create();

    $response = $this->get(route('api.education.absence-types.show', $absenceType->id));
    $response->assertSuccessful()
      ->assertStatus(200)
      ->assertJsonStructure(['data' => ['id']]);

    $this->assertEquals($absenceType->id, $response->json('data.id'));
  }
}
