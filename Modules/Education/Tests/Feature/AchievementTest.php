<?php

namespace Modules\Education\Tests\Feature;

use App\Models\School;
use Modules\Education\Entities\Session;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Education\Entities\Achievement;
use Modules\Education\Entities\AchievementType;
use Modules\Education\Entities\Clazz;

class AchievementTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function setUp(): void
  {
    parent::setUp();

    $this->setUpUser(['education.achievement.*']);
  }

  /** @test * */
  public function can_get_achievements()
  {
    $achievements = Achievement::factory()->count(5);

    $class = Clazz::factory()->create();
    $school = School::factory()->create();
    $achievement_type = AchievementType::factory()->create();

    $achievements->create([
      'class_id' => $class->id,
      'achievement_type_id' => $achievement_type->id,
      'school_id' => $school->id,
    ]);

    $response = $this->get(route('api.education.achievements.index'));

    $response->assertOk();
    $response->assertSuccessful()
      ->assertJsonCount(5, 'data')
      ->assertStatus(200);

  }

  /** @test * */
  public function can_create_achievement()
  {
    $achievement = Achievement::factory()->makeOne()->toArray();

    $class = Clazz::factory()->create();
    $school = School::factory()->create();
    $achievement_type = AchievementType::factory()->create();
    $session = Session::factory()->create();



    $achievement['class'] = $class->only(['id', 'name']);
    $achievement['achievement_type'] = $achievement_type->only(['id', 'name']);
    $achievement['school'] = $school->only(['id', 'name']);
    $achievement['achievable'] = [
      'achievable_id' => $session->id,
      'achievable_type' => 'education.session'
    ];

    $response = $this->post(route('api.education.achievements.store'), $achievement);

    $response->assertSuccessful()
      ->assertStatus(201);
  }

  /** @test * */
  public function can_update_achievement()
  {
    $class = Clazz::factory()->create();
    $school = School::factory()->create();
    $achievement_type = AchievementType::factory()->create();
    $session = Session::factory()->create();

    $achievement = Achievement::factory()->create([
      'class_id' => $class->id,
      'achievement_type_id' => $achievement_type->id,
      'school_id' => $class->id
    ]);

    $achievement->class = $class->only('id', 'name');
    $achievement->achievement_type = $achievement_type->only('id', 'name');
    $achievement->school = $school->only('id', 'name');
    $achievement->achievable = [
      'achievable_id' => $session->id,
      'achievable_type' => Session::class
    ];


    $achievement->start_time = $this->faker->time();

    $response = $this->put(route('api.education.achievements.update', $achievement->id), $achievement->toArray());

    $response->assertStatus(200);

    $this->assertDatabaseHas('achievements', [
      'id' => $achievement->id,
      'start_time' => $achievement->start_time
    ]);
  }

  /** @test * */
  public function can_delete_achievement()
  {
    $achievement = Achievement::factory()->create();

    $response = $this->delete(route('api.education.achievements.destroy', $achievement->id));

    $response->assertStatus(200);

    $this->assertDatabaseMissing('achievements', [
      'id' => $achievement->id
    ]);
  }

  /** @test */
  public function can_show_achievement()
  {
    $achievement = Achievement::factory()->create();

    $response = $this->get(route('api.education.achievements.show', $achievement->id));

    $response->assertStatus(200);

    $this->assertEquals($achievement->id, $response->json('data.id'));
  }
}
