<?php

namespace Tests\Feature\Models;

use App\Models\MeasureUnit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;
use \App\Models\MeasureUnitCategory;

class MeasureUnitCategoryTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function setUp(): void
  {
    parent::setUp();

    $this->setUpUser(['base.measure-unit-category.*']);
  }

  /** @test */
  public function can_create_measure_unit_category()
  {
    $measureUnitCategory = $this->createMeasureUnitCategory();

    $this->post(route('api.measure-unit-categories.store'), $measureUnitCategory->toArray());

    $this->assertDatabaseHas($measureUnitCategory, [
      'name' => $measureUnitCategory->name,
    ]);
  }

  /** @test */
  public function can_update_measure_unit_category()
  {
    $measureUnitCategory = $this->createMeasureUnitCategory();

    $measureUnitCategory->save();

    $measureUnitCategory->name = 'Updated';

    $this->put(route('api.measure-unit-categories.update', $measureUnitCategory->id), [
      'name' => $measureUnitCategory->name,
    ]);

    $this->assertDatabaseHas($measureUnitCategory, [
      'name' => 'Updated',
    ]);
  }

  /** @test */
  public function can_delete_measure_unit_category()
  {
    $measureUnitCategory = $this->createMeasureUnitCategory();

    $measureUnitCategory->save();

    $this->delete(route('api.measure-unit-categories.destroy', $measureUnitCategory->id));

    $this->assertDatabaseMissing($measureUnitCategory, [
      'name' => $measureUnitCategory->name,
    ]);
  }

  /** @test */
  public function can_list_measure_unit_categories()
  {
    $measureUnitCategory = $this->createMeasureUnitCategory();

    $measureUnitCategory->save();

    $this->get(route('api.measure-unit-categories.index'));

    $this->assertDatabaseHas($measureUnitCategory, [
      'name' => $measureUnitCategory->name,
    ]);
  }

  /** @test */
  public function can_show_measure_unit_category()
  {
    $measureUnitCategory = $this->createMeasureUnitCategory();

    $measureUnitCategory->save();

    $this->get(route('api.measure-unit-categories.show', $measureUnitCategory->id));

    $this->assertDatabaseHas($measureUnitCategory, [
      'name' => $measureUnitCategory->name,
    ]);
  }

  /** @test */
  public function cannot_destroy_measure_unit_category_in_use()
  {
    $measureUnitCategory = $this->createMeasureUnitCategory();

    $measureUnitCategory->save();

    $measureUnitCategory->units()->create(MeasureUnit::factory()->make()->toArray());

    $response = $this->delete(route('api.measure-unit-categories.destroy', $measureUnitCategory->id));

    $response->assertStatus(422);

    $this->assertDatabaseHas($measureUnitCategory, [
      'name' => $measureUnitCategory->name,
    ]);
  }

  private function createMeasureUnitCategory(): MeasureUnitCategory
  {
    return MeasureUnitCategory::factory()->make();
  }
}
