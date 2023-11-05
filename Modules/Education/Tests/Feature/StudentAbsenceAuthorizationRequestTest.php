<?php

namespace Modules\Education\Tests\Feature;

use App\Models\School;
use App\Models\User;
use Modules\Education\Entities\StudentAbsenceAuthorizationRequest;
use Modules\Education\Entities\Subscription;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StudentAbsenceAuthorizationRequestTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function setUp(): void
  {
    parent::setUp();

    $this->setUpUser(['education.student-absence-authorization-request.*']);
  }

  /** @test * */
  public function can_get_student_absence_authorization_requests()
  {
    $studentAbsenceAuthorizationRequest = StudentAbsenceAuthorizationRequest::factory()->count(5); //->create()
    $subscription = Subscription::factory()->create();
    $accepted_by = User::factory()->create();
    $school = School::factory()->create();

    $studentAbsenceAuthorizationRequest->create([
      'subscription_id' => $subscription->id,
      'accepted_by' => $accepted_by->id,
      'school_id' => $school->id,
    ]);

    $response = $this->get(route('api.education.student-absence-requests.index'));

    $response->assertOk();
    $response->assertSuccessful();
    $response->assertJsonCount(5, 'data');
    $response->assertStatus(200);
  }

  /** @test * */
  public function can_create_student_absence_authorization_request()
  {
    $studentAbsenceAuthorizationRequest = StudentAbsenceAuthorizationRequest::factory()->makeOne()->toArray();

    $subscription = Subscription::factory()->create();
    $accepted_by = User::factory()->create();
    $school = School::factory()->create();

    $studentAbsenceAuthorizationRequest['subscription'] = $subscription->only(["id"]);
    $studentAbsenceAuthorizationRequest['accepted_by'] = $accepted_by->only(["id"]);
    $studentAbsenceAuthorizationRequest['school'] = $school->only(["id"]);

    $response = $this->post(route('api.education.student-absence-requests.store'), $studentAbsenceAuthorizationRequest);

    // $response->assertOk();
    $response->assertSuccessful();
    $response->assertJsonStructure(['data' => ['id', 'subscription', 'accepted_by', 'school']]);
    $response->assertStatus(201);
  }

  /** @test * */
  public function can_update_student_absence_authorization_request()
  {
    $subscription = Subscription::factory()->create();
    $acceptedBy = User::factory()->create();
    $school = School::factory()->create();

    $studentAbsenceAuthorizationRequest = StudentAbsenceAuthorizationRequest::factory()->create([
      'subscription_id' => $subscription->id,
      'accepted_by' => $acceptedBy->id,
      'school_id' => $school->id,
    ]);

    $studentAbsenceAuthorizationRequest->subscription = $subscription->only(["id"]);
    $studentAbsenceAuthorizationRequest->accepted_by = $acceptedBy->only(["id"]);
    $studentAbsenceAuthorizationRequest->school = $school->only(["id"]);

    $response = $this->put(route('api.education.student-absence-requests.update', $studentAbsenceAuthorizationRequest->id), $studentAbsenceAuthorizationRequest->toArray());
    $response->assertSuccessful();
    $response->assertJsonStructure(['data' => ['id', 'subscription', 'accepted_by', 'school']]);
    $this->assertDatabaseHas('student_absence_authorization_requests', ['id' => $studentAbsenceAuthorizationRequest->id]);
  }

  /** @test * */
  public function can_delete_student_absence_authorization_request()
  {
    $studentAbsenceAuthorizationRequest = StudentAbsenceAuthorizationRequest::factory()->create();

    $response = $this->delete(route('api.education.student-absence-requests.destroy', $studentAbsenceAuthorizationRequest->id));

    $response->assertStatus(200);

    $this->assertDatabaseMissing('student_absence_authorization_requests', [
      'id' => $studentAbsenceAuthorizationRequest->id
    ]);
  }

  /** @test * */
  public function can_show_student_absence_authorization_request()
  {
    $studentAbsenceAuthorizationRequest = StudentAbsenceAuthorizationRequest::factory()->create();

    $response = $this->get(route('api.education.student-absence-requests.show', $studentAbsenceAuthorizationRequest->id));

    $response->assertStatus(200);

    $this->assertEquals($studentAbsenceAuthorizationRequest->id, $response->json('data.id'));
  }
}
