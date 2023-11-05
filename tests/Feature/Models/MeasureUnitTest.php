<?php

namespace Tests\Feature\Models;

use App\Models\MeasureUnitCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;
use \App\Models\MeasureUnit;

class MeasureUnitTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function setUp(): void
  {
    parent::setUp();

    $this->setUpUser(['base.measure-unit.*']);
  }

  /** @test */
  public function can_create_measure_unit()
  {
    $measureUnit = $this->createMeasureUnit();

    $this->post(route('api.measure-units.store'), $measureUnit->toArray());

    $this->assertDatabaseHas('measure_units', [
      'name' => $measureUnit->name,
    ]);
  }

  /** @test */
  public function can_update_measure_unit()
  {
    $measureUnit = $this->createMeasureUnit();

    $measureUnit->save();

    $measureUnit->name = 'Updated';

    $this->put(route('api.measure-units.update', $measureUnit->id), $measureUnit->toArray());

    $this->assertDatabaseHas('measure_units', [
      'name' => 'Updated',
    ]);
  }

  /** @test */
  public function can_delete_measure_unit()
  {
    $measureUnitCategory = $this->createMeasureUnit();

    $measureUnitCategory->save();

    $this->delete(route('api.measure-units.destroy', $measureUnitCategory->id));

    $this->assertDatabaseMissing('measure_units', [
      'name' => $measureUnitCategory->name,
    ]);
  }

  /** @test */
  public function can_list_measure_unit()
  {
    $measureUnitCategory = $this->createMeasureUnit();

    $measureUnitCategory->save();

    $this->get(route('api.measure-units.index'));

    $this->assertDatabaseHas('measure_units', [
      'name' => $measureUnitCategory->name,
    ]);
  }

  /** @test */
  public function can_show_measure_unit()
  {
    $measureUnit = $this->createMeasureUnit();

    $measureUnit = $this->createMeasureUnit();

    $measureUnit->save();

    $this->get(route('api.measure-units.show', $measureUnit->id));

    $this->assertDatabaseHas('measure_units', [
      'name' => $measureUnit->name,
    ]);
  }

  private function createMeasureUnit(): MeasureUnit
  {
    $category = $this->createMeasureUnitCategory();

    $category->save();

    $unit = MeasureUnit::factory()->make();

    $unit->category()->associate($category);

    return $unit;
  }

  private function createMeasureUnitCategory(): MeasureUnitCategory
  {
    return MeasureUnitCategory::factory()->make();
  }
}
