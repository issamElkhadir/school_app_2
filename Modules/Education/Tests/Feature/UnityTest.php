<?php

namespace Modules\Education\Tests\Feature;

use Modules\Education\Entities\Unity;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UnityTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function setUp(): void
  {
    parent::setUp();

    $this->setUpUser(['education.unity.*']);
  }

  /** @test */
  public function can_get_unities()
  {
    Unity::factory()->count(5)->create();

    $response = $this->get(route('api.education.unities.index'));

    $response->assertSuccessful()
      ->assertJsonCount(5, 'data');

  }

  /** @test */
  public function can_create_unity()
  {
    $unity = Unity::factory()->makeOne()->toArray();

    $response = $this->post(route('api.education.unities.store'), $unity);

    $response->assertStatus(201);

    $this->assertDatabaseHas('unities', [
      'name' => $unity['name'],
    ]);
  }

  /** @test */
  public function can_update_unity()
  {
    $unity = Unity::factory()->create();

    $unity->name = $this->faker->name();

    $response = $this->put(route('api.education.unities.update', $unity->id), $unity->toArray());

    $response->assertStatus(200);

    $this->assertDatabaseHas('unities', [
      'name' => $unity->name
    ]);
  }

  /** @test */
  public function can_delete_unity()
  {
    $unity = Unity::factory()->create();

    $response = $this->delete(route('api.education.unities.destroy', $unity->id));

    $response->assertStatus(200);

    $this->assertDatabaseMissing('unities', [
      'id' => $unity->id
    ]);
  }

  /** @test */
  public function can_show_unity()
  {

    $unity = Unity::factory()->create();

    $response = $this->get(route('api.education.unities.show', $unity->id));

    $response->assertStatus(200);

    $this->assertEquals($unity->name, $response->json('data.name'));
  }
}
