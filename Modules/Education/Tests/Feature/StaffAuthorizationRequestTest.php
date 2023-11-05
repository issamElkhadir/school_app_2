<?php

namespace Modules\Education\Tests\Feature;

use App\Models\School;
use App\Models\User;
use Modules\Education\Entities\Staff;
use Modules\Education\Entities\StaffAuthorizationRequest;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StaffAuthorizationRequestTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function setUp(): void
  {
    parent::setUp();

    $this->setUpUser(['education.staff-authorization-request.*']);
  }

  /** @test * */
  public function can_get_staff_authorization_requests()
  {
    $staffAuthorizationsRequest = StaffAuthorizationRequest::factory()->count(5);

    $staff = Staff::factory()->create();
    $responsible = User::factory()->create();
    $school = School::factory()->create();

    $staffAuthorizationsRequest->create([
      'staff_id' => $staff->id,
      'responsible_id' => $responsible->id,
      'school_id' => $school->id,
    ]);

    $response = $this->get(route('api.education.staff-authorization-requests.index'));

    $response->assertOk();
    $response->assertSuccessful();
    $response->assertJsonCount(5, 'data');
    $response->assertStatus(200);
  }

  /** @test * */
  public function can_create_staff_authorization_request()
  {
    $staffAuthorizationRequest = StaffAuthorizationRequest::factory()->makeOne()->toArray(); //->create()

    $staff = Staff::factory()->create();
    $responsible = User::factory()->create();
    $school = School::factory()->create();

    $staffAuthorizationRequest['staff'] = $staff->only(["id"]);
    $staffAuthorizationRequest['responsible'] = $responsible->only(["id"]);
    $staffAuthorizationRequest['school'] = $school->only(["id"]);

    $response = $this->post(route('api.education.staff-authorization-requests.store'), $staffAuthorizationRequest);

    $response->assertSuccessful();
    $response->assertJsonStructure(['data' => ['id', 'staff', 'responsible', 'school']]);
    $response->assertStatus(201);
  }

  /** @test * */
  public function can_update_staff_authorization_request()
  {
    $staff = Staff::factory()->create();
    $responsible = User::factory()->create();
    $school = School::factory()->create();

    $staffAuthorizationRequest = StaffAuthorizationRequest::factory()->create([
      'staff_id' => $staff->id,
      'responsible_id' => $responsible->id,
      'school_id' => $school->id,
    ]);

    $staffAuthorizationRequest->staff = $staff->only(["id"]);
    $staffAuthorizationRequest->responsible = $responsible->only(["id"]);
    $staffAuthorizationRequest->school = $school->only(["id"]);

    $response = $this->putJson(route('api.education.staff-authorization-requests.update', $staffAuthorizationRequest->id), $staffAuthorizationRequest->toArray());
    $response->assertSuccessful();
    $response->assertJsonStructure(['data' => ['id', 'staff', 'responsible', 'school']]);
    $this->assertDatabaseHas('staff_authorization_requests', ['id' => $staffAuthorizationRequest->id]);
  }

  /** @test * */
  public function can_delete_staff_authorization_request()
  {
    $staffAuthorizationRequest = StaffAuthorizationRequest::factory()->create();

    $response = $this->delete(route('api.education.staff-authorization-requests.destroy', $staffAuthorizationRequest->id));

    $response->assertStatus(200);

    $this->assertDatabaseMissing('staff_authorization_requests', [
      'id' => $staffAuthorizationRequest->id
    ]);
  }

  /** @test * */
  public function can_show_staff_authorization_request()
  {
    $staffAuthorizationRequest = StaffAuthorizationRequest::factory()->create();

    $response = $this->get(route('api.education.staff-authorization-requests.show', $staffAuthorizationRequest->id));

    $response->assertStatus(200);

    $this->assertEquals($staffAuthorizationRequest->id, $response->json('data.id'));
  }
}
