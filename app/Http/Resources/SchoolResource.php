<?php

namespace App\Http\Resources;

use App\Http\Resources\CityResource;
use App\Http\Resources\CountryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\School;
use Modules\Education\Transformers\ClassroomResource;

/** @mixin School */
class SchoolResource extends JsonResource
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
      'name' => $this->whenHas('name', $this->name),
      'country' => CountryResource::make($this->whenLoaded('country')),
      'city' => new CityResource($this->whenLoaded('city')),
      'classrooms' => ClassroomResource::collection($this->whenLoaded('classrooms')),
      'short_name' => $this->whenHas('short_name', $this->short_name),
      'rtl_name' => $this->whenHas('rtl_name', $this->rtl_name),
      'active' => $this->whenHas('active', $this->active),
      'authorization_date' => $this->whenHas('authorization_date', $this->authorization_date),
      'authorization_number' => $this->whenHas('authorization_number', $this->authorization_number),
      'authorization_information' => $this->whenHas('authorization_information', $this->authorization_information),
      'rtl_authorization_information' => $this->whenHas('rtl_authorization_information', $this->rtl_authorization_information),
      'cnss' => $this->whenHas('cnss', $this->cnss),
      'rc' => $this->whenHas('rc', $this->rc),
      'ice' => $this->whenHas('ice', $this->ice),
      'establishment_type' => $this->whenHas('establishment_type', $this->establishment_type),
      'responsible_name' => $this->whenHas('responsible_name', $this->responsible_name),
      'responsible_phone_number' => $this->whenHas('responsible_phone_number', $this->responsible_phone_number),


      'contact_address' => $this->whenHas('contact_address', $this->contact_address),
      'contact_rtl_address' => $this->whenHas('contact_rtl_address', $this->contact_rtl_address),
      'contact_name' => $this->whenHas('contact_name', $this->contact_name),
      'contact_email' => $this->whenHas('contact_email', $this->contact_email),
      'contact_whatsapp' => $this->whenHas('contact_whatsapp', $this->contact_whatsapp),
      'contact_website' => $this->whenHas('contact_website', $this->contact_website),
      'contact_phone_1' => $this->whenHas('contact_phone_1', $this->contact_phone_1),
      'contact_phone_2' => $this->whenHas('contact_phone_2', $this->contact_phone_2),
      'contact_mobile_1' => $this->whenHas('contact_mobile_1', $this->contact_mobile_1),
      'contact_mobile_2' => $this->whenHas('contact_mobile_2', $this->contact_mobile_2),
      'contact_fax_1' => $this->whenHas('contact_fax_1', $this->contact_fax_1),
      'contact_fax_2' => $this->whenHas('contact_fax_2', $this->contact_fax_2),
      'contact_street' => $this->whenHas('contact_street', $this->contact_street),
      'contact_zip' => $this->whenHas('contact_zip', $this->contact_zip),


    ];
  }
}
