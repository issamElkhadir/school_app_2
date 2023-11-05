<?php

namespace Modules\Education\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Education\Entities\ContractType;
use Modules\Education\Entities\EmploymentContract;
use Modules\Education\Entities\Staff;

class EmploymentContractTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->setUpUser(['education.employment-contract.*']);
    }
      /** @test * */
    public function it_can_get_employment_contracts()
    {
        $employmentContracts = EmploymentContract::factory()->count(10);
        $staff = Staff::factory()->create();
        $contractType = ContractType::factory()->create();

        $employmentContracts->create([
            'contract_type_id' => $contractType->id,
            'staff_id' => $staff->id
        ]);

        $response = $this->get(route('api.education.employment-contracts.index'));

        $response->assertSuccessful()
        ->assertJsonCount(10, 'data')
        ->assertStatus(200);
    }
    /** @test */
    public function it_can_create_employment_contract()
    {
        $employmentContract = EmploymentContract::factory()->makeOne()->toArray();
        $staff = Staff::factory()->create();
        $contractType = ContractType::factory()->create();

        $employmentContract['contract_type'] = $contractType->only(['id', 'name']);
        $employmentContract['staff'] = $staff->only(['id', 'name']);

        $response = $this->post(route('api.education.employment-contracts.store'), $employmentContract);
        $response->assertSuccessful()
            ->assertStatus(201)
            ->assertJsonStructure(['data' => ['id', 'staff', 'contract_type']]);
        

        $this->assertDatabaseHas('employment_contracts', [
            'contract_type_id' => $contractType->id,
            'staff_id' => $staff->id
        ]);
    }

    /** @test */
    public function it_can_update_employment_contract()
    {
        $staff = Staff::factory()->create();
        $contractType = ContractType::factory()->create();

        $employmentContract = EmploymentContract::factory()->create([
            'contract_type_id' => $contractType->id,
            'staff_id' => $staff->id
        ]);

        $employmentContract->contract_type = $contractType->only('id', 'name');
        $employmentContract->staff = $staff->only('id', 'name');

        $response = $this->put(route('api.education.employment-contracts.update' , $employmentContract->id), $employmentContract->toArray());
        $response->assertOk()
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['id', 'staff', 'contract_type']]);
        

        $this->assertDatabaseHas('employment_contracts', [
            'contract_type_id' => $contractType->id,
            'staff_id' => $staff->id
        ]);
    }

    /** @test */
    public function it_can_delete_employment_contract()
    {
        $staff = Staff::factory()->create();
        $contractType = ContractType::factory()->create();

        $employmentContract = EmploymentContract::factory()->create([
            'staff_id' => $staff->id ,
            'contract_type_id' => $contractType->id
        ]);

        $response = $this->delete(route('api.education.employment-contracts.destroy', $employmentContract->id));

        $response->assertSuccessful()
            ->assertStatus(200);

        $this->assertDatabaseMissing('employment_contracts', [
            'id' => $employmentContract->id
        ]);
    }

    /** @test */

    public function it_can_show_employment_contract()
    {
        $staff = Staff::factory()->create();
        $contractType = ContractType::factory()->create();

        $employmentContract = EmploymentContract::factory()->create([
            'staff_id' => $staff->id,
            'contract_type_id' => $contractType->id
        ]);

        $response = $this->get(route('api.education.employment-contracts.show', $employmentContract->id));

        $response->assertSuccessful()
            ->assertStatus(200)
            ->assertJsonStructure(['data' => ['id','staff', 'contract_type']]);

        $this->assertEquals($employmentContract->id, $response->json('data.id'));
    }
}
