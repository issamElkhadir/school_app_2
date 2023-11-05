<?php

namespace Modules\Education\Tests\Feature;

use Modules\Education\Entities\Level;
use Modules\Education\Entities\Skill;
use Modules\Education\Entities\Staff;
use Modules\Education\Entities\Subject;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SkillTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function setUp(): void
  {
    parent::setUp();

    $this->setUpUser(['education.staff.*']);
  }

  /** @test */
  public function can_get_skills()
  {
    $skill = Skill::factory()->count(5);

    $cycle = Subject::factory()->create();
    $staff = Staff::factory()->create();
    $level = Level::factory()->create();

    $skill->create([
      'subject_id' => $cycle->id,
      'staff_id' => $staff->id,
      'level_id' => $level->id,
    ]);

    $response = $this->get(route('api.education.skills.index'));

    $response->assertSuccessful()
      ->assertJsonCount(5, 'data');

  }

  /** @test */
  public function can_create_skill()
  {
    $skill = Skill::factory()->makeOne()->toArray();

    $cycle = Subject::factory()->create();
    $staff = Staff::factory()->create();
    $level = Level::factory()->create();

    $skill['subject'] = $cycle->only('id', 'name');
    $skill['staff'] = $staff->only('id');
    $skill['level'] = $level->only('id', 'name');

    $response = $this->post(route('api.education.skills.store'), $skill);

    $response->assertStatus(201);

    $this->assertDatabaseHas('skills', [
      'note' => $skill['note'],
    ]);
  }

  /** @test */
  public function can_update_skill()
  {
    $subject = Subject::factory()->create();
    $level = Level::factory()->create();
    $staff = Staff::factory()->create();

    $skill = Skill::factory()->create([
      'subject_id' => $subject->id,
      'level_id' => $level->id,
      'staff_id' => $staff->id,
    ]);

    $skill->subject = $subject->only('id', 'name');
    $skill->level = $level->only('id', 'name');
    $skill->staff = $staff->only('id');


    $skill->note = $this->faker->name();

    $response = $this->put(route('api.education.skills.update', $skill->id), $skill->toArray());

    $response->assertStatus(200);

    $this->assertDatabaseHas('skills', [
      'note' => $skill->note
    ]);
  }

  /** @test */
  public function can_delete_skill()
  {
    $subject = Subject::factory()->create();
    $level = Level::factory()->create();
    $staff = Staff::factory()->create();

    $skill = Skill::factory()->create([
      'subject_id' => $subject->id,
      'level_id' => $level->id,
      'staff_id' => $staff->id,
    ]);

    $response = $this->delete(route('api.education.skills.destroy', $skill->id));

    $response->assertStatus(200);

    $this->assertDatabaseMissing('skills', [
      'id' => $skill->id
    ]);
  }

  /** @test */
  public function can_show_skill()
  {
    $subject = Subject::factory()->create();
    $level = Level::factory()->create();
    $staff = Staff::factory()->create();

    $skill = Skill::factory()->create([
      'subject_id' => $subject->id,
      'level_id' => $level->id,
      'staff_id' => $staff->id,
    ]);

    $response = $this->get(route('api.education.skills.show', $skill->id));

    $response->assertStatus(200);

    $this->assertEquals($skill->note, $response->json('data.note'));
  }
}
