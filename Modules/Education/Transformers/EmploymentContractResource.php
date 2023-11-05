<?php

namespace Modules\Education\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class EmploymentContractResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id ,
            'staff' => new StaffResource($this->whenLoaded('staff')) ,
            'contract_start_date' => $this->whenHas('contract_start_date' , $this->contract_start_date),
            'contract_end_date' => $this->whenHas('contract_end_date' , $this->contract_end_date),
            'net_salary' => $this->whenHas('net_salary' , $this->net_salary),
            'brut_salary' => $this->whenHas('brut_salary' , $this->brut_salary),
            'nbr_days_off' => $this->whenHas('nbr_days_off' , $this->nbr_days_off),
            'contract_type' => new ContractTypeResource($this->whenLoaded('contract_type'))
        ];
    }
}
