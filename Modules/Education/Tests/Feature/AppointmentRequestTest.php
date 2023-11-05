<?php

namespace Modules\Education\Tests\Feature;

use App\Models\City;
use App\Models\Country;
use App\Models\School;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Education\Entities\AppointmentRequest;
use Modules\Education\Entities\Guardian;
use Modules\Education\Entities\Staff;
use Modules\Education\Entities\Student;

class AppointmentRequestTest extends TestCase
{
  use WithFaker, RefreshDatabase;

  public function setUp(): void
  {
    parent::setUp();

    $this->setUpUser(['education.appointment-request.*']);
  }

  /** @test */

  public function it_can_get_appointment_requests()
  {
    $appointmentRequests = AppointmentRequest::factory()->count(10);
    $school = School::factory()->create();
    $staff = Staff::factory()->create();
    $student = Student::factory()->create();
    $guardian = Guardian::factory()->create();

    $appointmentRequests->create([
      'school_id' => $school->id,
      'staff_id' => $staff->id,
      'student_id' => $student->id,
      'guardian_id' => $guardian->id,
    ]);

    $response = $this->get(route('api.education.appointment-requests.index'));

    $response->assertSuccessful()
      ->assertJsonCount(10, 'data', 'Expected 10 doctors in the response')
      ->assertStatus(200, 'The response status code is not 200');
  }

  /** @test */
  public function it_can_create_an_appointment_request()
  {
    $student = Student::factory()->create();
    $staff = Staff::factory()->create();
    $guardian = Guardian::factory()->create();
    $school = School::factory()->create();

    $appointmentRequest = AppointmentRequest::factory()->makeOne([
      'student_id' => $student->id,
    ])->toArray();

    $appointmentRequest['school'] = $school->only('id', 'name');
    $appointmentRequest['student'] = $student->only('id', 'name');
    $appointmentRequest['staff'] = $staff->only('id', 'name');
    $appointmentRequest['guardian'] = $guardian->only('id', 'name');

    $response = $this->post(route('api.education.appointment-requests.store'), $appointmentRequest);

    $response->assertSuccessful()
      ->assertStatus(201, 'The response status code is not 200')
      ->assertJsonStructure(['data' => ['id', 'school', 'staff', 'student', 'guardian']]);

  }

  /** @test */
  public function it_can_update_an_appointment_request()
  {
   $school = School::factory()->create();

    $appointmentRequest = AppointmentRequest::factory()->create([
      'school_id' => $school->id,
    ]);

    $appointmentRequest->school = $school->only('id', 'name');

    $response = $this->put(route('api.education.appointment-requests.update', $appointmentRequest->id), $appointmentRequest->toArray());

    $response->assertSuccessful()
      ->assertStatus(200, 'The response status code is not 200')
      ->assertJsonStructure(['data' => ['id', 'school', 'staff', 'student', 'guardian']]);

    $this->assertDatabaseHas('appointment_requests', [
      'id' => $appointmentRequest->id,
    ]);
  }

  /** @test */
  public function it_can_show_appointment_request()
  {
    $appointmentRequest = AppointmentRequest::factory()->create();

    $response = $this->get(route('api.education.appointment-requests.show', $appointmentRequest->id));

    $response->assertSuccessful()
      ->assertStatus(200, 'The response status code is not 200')
      ->assertJsonStructure(['data' => ['id', 'school', 'staff', 'student', 'guardian']]);

    $this->assertEquals($appointmentRequest->id, $response->json('data.id'));
  }

  /** @test */
  public function it_can_delete_an_appointment_request()
  {
    $appointmentRequest = AppointmentRequest::factory()->create();

    $response = $this->delete(route('api.education.appointment-requests.destroy', $appointmentRequest->id));

    $response->assertSuccessful()
      ->assertStatus(200, 'The response status code is not 200');

    $this->assertDatabaseMissing('appointment_requests', ['id' => $appointmentRequest->id]);
  }

}
