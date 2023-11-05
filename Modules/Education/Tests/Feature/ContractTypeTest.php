<?php

namespace Modules\Education\Tests\Feature;

use App\Models\School;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Education\Entities\ContractType;

class ContractTypeTest extends TestCase
{
    use WithFaker , RefreshDatabase ;
    
    public function setUp(): void
    {
        parent::setUp();

        $this->setUpUser(['education.contract-type.*']);    
    }

    /** @test * */
  public function it_can_get_contract_types()
  {
    $contractType = ContractType::factory()->count(10);
    $school = School::factory()->create();

    $contractType->create([
      'school_id' => $school->id
    ]);

    $response = $this->get(route('api.education.contract-types.index'));

    $response->assertSuccessful()
      ->assertJsonCount(10, 'data')
      ->assertStatus(200);
  }

  /** @test * */
  public function it_can_create_a_contract_type()
  {
    $contractType = ContractType::factory()->makeOne()->toArray();
    $school = School::factory()->create();
    $contractType['school'] = $school->only(['id', 'name']);

    $response = $this->post(route('api.education.contract-types.store'), $contractType);

    $response
      ->assertStatus(201)
      ->assertSuccessful()
      ->assertJsonStructure(['data' => ['id', 'school']]);
  }

   /** @test * */
   public function it_can_update_a_contract_type()
   {
     $school = School::factory()->create();
     $contractType = ContractType::factory()->create([
       'school_id' => $school
     ]);
 
     $contractType->school = $school->only('id', 'name');
 
     $response = $this->put(route('api.education.contract-types.update', $contractType->id), $contractType->toArray());
 
     $response->assertOk()
       ->assertSuccessful()
       ->assertJsonStructure(['data' => ['id', 'school']]);
 
     $this->assertDatabaseHas('contract_types', [
       'id' => $contractType->id,
       'name' => $contractType->name
     ]);
   }

   /** @test * */
  public function it_can_delete_a_contract_type()
  {
    $contractType = ContractType::factory()->create();

    $response = $this->delete(route('api.education.contract-types.destroy', $contractType->id));

    $response->assertSuccessful()
      ->assertStatus(200);

    $this->assertDatabaseMissing('contract_types', [
      'id' => $contractType->id
    ]);
  }

  /** @test * */
  public function it_can_show_contract_type()
  {
    $contractType = ContractType::factory()->create();

    $response = $this->get(route('api.education.contract-types.show', $contractType->id));
    $response->assertSuccessful()
      ->assertStatus(200)
      ->assertJsonStructure(['data' => ['id', 'school']]);

    $this->assertEquals($contractType->name, $response->json('data.name'));
  }
 
}
