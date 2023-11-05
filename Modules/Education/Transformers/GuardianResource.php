<?php

namespace Modules\Education\Transformers;

use App\Http\Resources\CityResource;
use App\Http\Resources\CountryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Education\Entities\Guardian;

/** @mixin Guardian */
class GuardianResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    return [
      'id' => $this->id,
      'first_name' => $this->whenHas('first_name', $this->first_name),
      'country' => new CountryResource($this->whenLoaded('country')),
      'city' => new CityResource($this->whenLoaded('city')),
      'last_name' => $this->whenHas('last_name', $this->last_name),
      'rtl_first_name' => $this->whenHas('rtl_first_name', $this->rtl_first_name),
      'rtl_last_name' => $this->whenHas('rtl_last_name', $this->rtl_last_name),
      'cni_number' => $this->whenHas('cni_number', $this->cni_number),
      'home_phone' => $this->whenHas('home_phone', $this->home_phone),
      'mobile_phone' => $this->whenHas('mobile_phone', $this->mobile_phone),
      'email_address' => $this->whenHas('email_address', $this->email_address),
      'gender' => $this->whenHas('gender', $this->gender),
      'created_at' => $this->whenHas('created_at', $this->created_at),
      'updated_at' => $this->whenHas('updated_at', $this->updated_at),
    ];
  }
}
