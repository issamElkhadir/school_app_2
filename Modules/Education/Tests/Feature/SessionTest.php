<?php

namespace Modules\Education\Tests\Feature;

use Modules\Education\Entities\Classroom;
use Modules\Education\Entities\Schedule;
use Modules\Education\Entities\Session;
use Modules\Education\Entities\Staff;
use Modules\Education\Entities\Subject;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SessionTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function setUp(): void
  {
    parent::setUp();

    $this->setUpUser(['education.session.*']);
  }

  /** @test */
  public function can_get_sessions()
  {
    $session = Session::factory()->count(5);

    $schedule = Schedule::factory()->create();
    $staff = Staff::factory()->create();
    $subject = Subject::factory()->create();
    $classroom = Classroom::factory()->create();
    $session->create([
      'schedule_id' => $schedule->id,
      'staff_id' => $staff->id,
      'subject_id' => $subject->id,
      'classroom_id' => $classroom->id,
    ]);

    $response = $this->get(route('api.education.sessions.index'));

    $response->assertSuccessful()
      ->assertJsonCount(5, 'data');

  }

  /** @test */
  public function can_create_session()
  {
    $session = Session::factory()->makeOne()->toArray();

    $schedule = Schedule::factory()->create();
    $staff = Staff::factory()->create();
    $subject = Subject::factory()->create();
    $classroom = Classroom::factory()->create();

    $session['schedule'] = ['id'=> $schedule->id, 'name' => $schedule->name];
    $session['staff'] = $staff->only('id' );
    $session['subject'] = $subject->only('id', 'name');
    $session['classroom'] = $classroom->only('id', 'name');

    $response = $this->post(route('api.education.sessions.store'), $session);

    $response->assertStatus(201);

    $this->assertDatabaseHas('sessions', [
      'name' => $session['name'],
    ]);
  }

  /** @test */
  public function can_update_session()
  {
    $schedule = Schedule::factory()->create();
    $staff = Staff::factory()->create();
    $subject = Subject::factory()->create();
    $classroom = Classroom::factory()->create();

    $session = Session::factory()->create([
      'schedule_id' => $schedule->id,
      'staff_id' => $staff->id,
      'subject_id' => $subject->id,
      'classroom_id' => $classroom->id,
    ]);

    $session->schedule = $schedule->only('id', 'name');
    $session->staff = $staff->only('id' );
    $session->subject = $subject->only('id', 'name');
    $session->classroom = $classroom->only('id', 'name');

    $session->name = $this->faker->name();


    $response = $this->put(route('api.education.sessions.update', $session->id), $session->toArray());

    $response->assertStatus(200);

    $this->assertDatabaseHas('sessions', [
      'name' => $session->name
    ]);
  }

  /** @test */
  public function can_delete_session()
  {
    $session = Session::factory()->create();

    $response = $this->delete(route('api.education.sessions.destroy', $session->id));

    $response->assertStatus(200);

    $this->assertDatabaseMissing('sessions', [
      'id' => $session->id
    ]);
  }

  /** @test */
  public function can_show_session()
  {
    $session = Session::factory()->create();

    $response = $this->get(route('api.education.sessions.show', $session->id));

    $response->assertStatus(200);

    $this->assertEquals($session->name, $response->json('data.name'));
  }
}
