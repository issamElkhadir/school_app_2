<?php

namespace Modules\Education\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Education\Entities\AchievementType;

class AchievementTypeTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function setUp(): void
  {
    parent::setUp();

    $this->setUpUser(['education.achievement-type.*']);
  }

  /** @test * */
  public function can_get_achievement_types()
  {
    AchievementType::factory()->count(5)->create();

    $response = $this->get(route('api.education.achievement-types.index'));

    $response->assertOk();
    $response->assertSuccessful()
      ->assertJsonCount(5, 'data')
      ->assertStatus(200);
  }

  /** @test * */
  public function can_create_achievement_types()
  {
    $achievementType = AchievementType::factory()->makeOne()->toArray();

    $response = $this->post(route('api.education.achievement-types.store'), $achievementType);

    $response->assertSuccessful()
      ->assertJsonStructure(['data' => ['id', 'name']])
      ->assertStatus(201);
  }

  /** @test * */

  public function can_update_achievement_types()
  {
    $achievementType = AchievementType::factory()->create();
    $achievementType->name = $this->faker->name();

    $response = $this->put(route('api.education.achievement-types.update', $achievementType->id), $achievementType->toArray());

    $response->assertStatus(200);

    $this->assertDatabaseHas('achievement_types', [
      'name' => $achievementType->name
    ]);
  }

  /** @test * */
  public function can_delete_achievement_types()
  {
    $achievementType = AchievementType::factory()->create();

    $response = $this->delete(route('api.education.achievement-types.destroy', $achievementType->id));

    $response->assertStatus(200);

    $this->assertDatabaseMissing('achievement_types', [
      'id' => $achievementType->id
    ]);
  }

  /** @test */
  public function can_show_achievement_types()
  {
    $achievementType = AchievementType::factory()->create();

    $response = $this->get(route('api.education.achievement-types.show', $achievementType->id));

    $response->assertStatus(200);

    $this->assertEquals($achievementType->name, $response->json('data.name'));
  }
}
