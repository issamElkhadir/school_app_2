<?php

namespace Modules\Education\Tests\Feature;

use App\Models\School;
use App\Models\User;
use Modules\Education\Entities\StudentAuthorizationRequest;
use Modules\Education\Entities\Subscription;
use Modules\Education\Entities\Unity;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StudentAuthorizationRequestTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function setUp(): void
  {
    parent::setUp();

    $this->setUpUser(['education.student-authorization-request.*']);
  }

  /** @test * */
  public function can_get_student_authorizations()
  {
    $studentAuthorizations = StudentAuthorizationRequest::factory()->count(5);
    $subscription = Subscription::factory()->create();
    $unity = Unity::factory()->create();
    $authorized_by = User::factory()->create();
    $school = School::factory()->create();

    $studentAuthorizations->create([
      'subscription_id' => $subscription->id,
      'unity_id' => $unity->id,
      'authorized_by' => $authorized_by->id,
      'school_id' => $school->id,
    ]);

    $response = $this->get(route('api.education.student-authorization-requests.index'));

    $response->assertOk();
    $response->assertSuccessful();
    $response->assertJsonCount(5, 'data');
    $response->assertStatus(200);
  }

  /** @test * */
  public function can_create_student_authorization()
  {
    $studentAuthorization = StudentAuthorizationRequest::factory()->makeOne()->toArray(); //->create()

    $subscription = Subscription::factory()->create();
    $unity = Unity::factory()->create();
    $authorized_by = User::factory()->create();
    $school = School::factory()->create();

    $studentAuthorization['subscription'] = $subscription->only(["id"]);
    $studentAuthorization['unity'] = $unity->only(["id"]);
    $studentAuthorization['authorized_by'] = $authorized_by->only(["id"]);
    $studentAuthorization['school'] = $school->only(["id"]);

    $response = $this->post(route('api.education.student-authorization-requests.store'), $studentAuthorization);

    $response->assertSuccessful();
    $response->assertJsonStructure(['data' => ['id', 'subscription', 'unity', 'authorized_by', 'school']]);
    $response->assertStatus(201);
  }

  /** @test * */
  public function can_update_student_authorization()
  {
    $subscription = Subscription::factory()->create();
    $unity = Unity::factory()->create();
    $authorized_by = User::factory()->create();
    $school = School::factory()->create();

    $studentAuthorization = StudentAuthorizationRequest::factory()->create([
      'subscription_id' => $subscription->id,
      'unity_id' => $unity->id,
      'authorized_by' => $authorized_by->id,
      'school_id' => $school->id,
    ]);

    $studentAuthorization->subscription = $subscription->only(["id"]);
    $studentAuthorization->unity = $unity->only(["id"]);
    $studentAuthorization->authorized_by = $authorized_by->only(["id"]);
    $studentAuthorization->school = $school->only(["id"]);

    $response = $this->put(route('api.education.student-authorization-requests.update', $studentAuthorization->id), $studentAuthorization->toArray());
    $response->assertSuccessful();
    $response->assertJsonStructure(['data' => ['id', 'subscription', 'unity', 'authorized_by', 'school']]);
    $this->assertDatabaseHas('student_authorization_requests', ['id' => $studentAuthorization->id]);
  }

  /** @test * */
  public function can_delete_student_authorization()
  {
    $studentAuthorization = StudentAuthorizationRequest::factory()->create();

    $response = $this->delete(route('api.education.student-authorization-requests.destroy', $studentAuthorization->id));

    $response->assertStatus(200);

    $this->assertDatabaseMissing('student_authorization_requests', [
      'id' => $studentAuthorization->id
    ]);
  }

  /** @test * */
  public function can_show_student_authorization()
  {
    $studentAuthorization = StudentAuthorizationRequest::factory()->create();

    $response = $this->get(route('api.education.student-authorization-requests.show', $studentAuthorization->id));

    $response->assertStatus(200);

    $this->assertEquals($studentAuthorization->id, $response->json('data.id'));
  }
}
