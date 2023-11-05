<?php

namespace Modules\Education\Tests\Feature;

use App\Models\School;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Education\Entities\MedicalForm;

class medicalFormTest extends TestCase
{
  use WithFaker, RefreshDatabase;

  public function setUp(): void
  {
    parent::setUp();

    $this->setUpUser(['education.medical-form.*']);
  }

  /** @test * */
  public function it_can_get_medical_forms()
  {
    $medicalForm = MedicalForm::factory()->count(10);
    $school = School::factory()->create();

    $medicalForm->create([
      'school_id' => $school->id
    ]);

    $response = $this->get(route('api.education.medical-forms.index'));

    $response->assertSuccessful()
      ->assertJsonCount(10, 'data')
      ->assertStatus(200);
  }

  /** @test * */
  public function it_can_create_a_medical_form()
  {
    $medicalForm = MedicalForm::factory()->makeOne()->toArray();
    $school = School::factory()->create();
    $medicalForm['school'] = $school->only(['id', 'name']);

    dd($medicalForm);
    $response = $this->post(route('api.education.medical-forms.store'), $medicalForm);

    $response
      ->assertStatus(201)
      ->assertSuccessful()
      ->assertJsonStructure(['data' => ['id', 'school']]);
  }

  /** @test * */
  public function it_can_update_a_medical_form()
  {
    $school = School::factory()->create();
    $medicalForm = MedicalForm::factory()->create([
      'school_id' => $school
    ]);

    $medicalForm->school = $school->only('id', 'name');

    $response = $this->put(route('api.education.medical-forms.update', $medicalForm->id), $medicalForm->toArray());

    $response->assertOk()
      ->assertSuccessful()
      ->assertJsonStructure(['data' => ['id', 'school']]);

    $this->assertDatabaseHas('medical_forms', [
      'id' => $medicalForm->id,
      'name' => $medicalForm->name
    ]);
  }

  /** @test * */
  public function it_can_delete_a_medical_form()
  {
    $medicalForm = MedicalForm::factory()->create();

    $response = $this->delete(route('api.education.medical-forms.destroy', $medicalForm->id));

    $response->assertSuccessful()
      ->assertStatus(200);

    $this->assertDatabaseMissing('medical_forms', [
      'id' => $medicalForm->id
    ]);
  }

  /** @test * */
  public function it_can_show_medical_form()
  {
    $medicalForm = MedicalForm::factory()->create();

    $response = $this->get(route('api.education.medical-forms.show', $medicalForm->id));
    $response->assertSuccessful()
      ->assertStatus(200)
      ->assertJsonStructure(['data' => ['id', 'school']]);

    $this->assertEquals($medicalForm->name, $response->json('data.name'));
  }
}
