<?php

namespace Modules\Education\Tests\Feature;

use App\Models\School;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Education\Entities\Doctor;

class DoctorTest extends TestCase
{
  use WithFaker, RefreshDatabase;

  public function setUp(): void
  {
    parent::setUp();

    $this->setUpUser(['education.doctor.*']);
  }

  /** @test * */
  public function it_can_get_doctors()
  {
    $doctors = Doctor::factory()->count(10);
    $school = School::factory()->create();

    $doctors->create([
      'school_id' => $school->id
    ]);

    $response = $this->get(route('api.education.doctors.index'));

    $response->assertSuccessful()
      ->assertJsonCount(10, 'data')
      ->assertStatus(200);
  }

  /** @test * */
  public function it_can_create_a_doctor()
  {
    $doctor = Doctor::factory()->makeOne()->toArray();
    $school = School::factory()->create();
    $doctor['school'] = $school->only(['id', 'name']);

    $response = $this->post(route('api.education.doctors.store'), $doctor);

    $response
      ->assertStatus(201)
      ->assertSuccessful()
      ->assertJsonStructure(['data' => ['id', 'school']]);
  }


  /** @test * */
  public function it_can_update_a_doctor()
  {
    $school = School::factory()->create();
    $doctor = Doctor::factory()->create([
      'school_id' => $school
    ]);

    $doctor->school = $school->only('id', 'name');

    $response = $this->put(route('api.education.doctors.update', $doctor->id), $doctor->toArray());

    $response->assertOk()
      ->assertSuccessful()
      ->assertJsonStructure(['data' => ['id', 'school']]);

    $this->assertDatabaseHas('doctors', [
      'id' => $doctor->id,
      'name' => $doctor->name
    ]);
  }

  /** @test * */

  public function it_can_delete_a_doctor()
  {
    $school = School::factory()->create();
    $doctor = Doctor::factory()->create([
      'school_id' => $school
    ]);

    $response = $this->delete(route('api.education.doctors.destroy', $doctor->id));

    $response->assertSuccessful()
      ->assertStatus(200);

    $this->assertDatabaseMissing('doctors', [
      'id' => $doctor->id
    ]);
  }

  /** @test * */
  public function it_can_show_doctor()
  {
    $school = School::factory()->create();
    $doctor = Doctor::factory()->create([
      'school_id' => $school
    ]);

    $response = $this->get(route('api.education.doctors.show', $doctor->id));
    $response->assertSuccessful()
      ->assertStatus(200)
      ->assertJsonStructure(['data' => ['id', 'school']]);
    $this->assertEquals($doctor->name, $response->json('data.name'));
  }
}
