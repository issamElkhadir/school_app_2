<?php

namespace Modules\Education\Tests\Feature;

use Modules\Education\Entities\Branch;
use Modules\Education\Entities\Clazz;
use Modules\Education\Entities\Level;
use Modules\Education\Entities\Schedule;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ScheduleTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function setUp(): void
  {
    parent::setUp();

    $this->setUpUser(['education.schedule.*']);
  }

  /** @test * */
  public function can_get_schedules()
  {
    $schedules = Schedule::factory()->count(5);

    $branch = Branch::factory()->create();
    $level = Level::factory()->create();
    $class = Clazz::factory()->create();

    $schedules->create([
      'branch_id' => $branch->id,
      'level_id' => $level->id,
      'class_id' => $class->id,
    ]);

    $response = $this->get(route('api.education.schedules.index'));

    $response->assertSuccessful()
      ->assertJsonCount(5, 'data')
      ->assertStatus(200);
  }


  /** @test * */
  public function can_create_schedule() {
    $schedule = Schedule::factory()->makeOne()->toArray();

    $branch = Branch::factory()->create();
    $level = Level::factory()->create();
    $class = Clazz::factory()->create();

    $schedule['branch'] = $branch->only(['id', 'name']);
    $schedule['level'] = $level->only(['id', 'name']);
    $schedule['class'] = $class->only(['id', 'name']);

    $response = $this->post(route('api.education.schedules.store'), $schedule);

    $response->assertSuccessful()
      ->assertJsonStructure(['data' => ['id', 'branch', 'level', 'class']])
      ->assertStatus(201);

  }

  /** @test **/
  public function can_update_schedule() {

    $branch = Branch::factory()->create();
    $level = Level::factory()->create();
    $class = Clazz::factory()->create();

    $schedule = Schedule::factory()->create([
      'branch_id' => $branch->id,
      'level_id' => $level->id,
      'class_id' => $class->id,
    ]);

    $schedule->branch = $branch->only('id', 'name');
    $schedule->level = $level->only('id', 'name');
    $schedule->class = $class->only('id', 'name');


    $response = $this->put(route('api.education.schedules.update', $schedule->id), $schedule->toArray());

    $response->assertSuccessful()
      ->assertJsonStructure(['data' => ['id', 'branch', 'level', 'class']]);

    $this->assertDatabaseHas('schedules', [
      'id' => $schedule->id,
      'name' => $schedule->name,
    ]);
  }

  /** @test **/
  public function can_show_schedule()
  {
    $branch = Branch::factory()->create();
    $level = Level::factory()->create();
    $class = Clazz::factory()->create();

    $schedule = Schedule::factory()->create([
      'branch_id' => $branch->id,
      'level_id' => $level->id,
      'class_id' => $class->id,
    ]);

    $response = $this->get(route('api.education.schedules.show', $schedule->id));

    $response->assertSuccessful()
      ->assertJsonStructure(['data' => ['id', 'branch', 'level', 'class']])
      ->assertStatus(200);

    $this->assertEquals($schedule->name, $response->json('data.name'));
  }

  /** @test */
  public function can_delete_schedule()
  {
    $branch = Branch::factory()->create();
    $level = Level::factory()->create();
    $class = Clazz::factory()->create();

    $schedule = Schedule::factory()->create([
      'branch_id' => $branch->id,
      'level_id' => $level->id,
      'class_id' => $class->id,
    ]);

    $response = $this->delete(route('api.education.schedules.destroy', $schedule->id));

    $response->assertStatus(200);

    $this->assertDatabaseMissing('schedules', [
      'id' => $schedule->id
    ]);
  }


}
