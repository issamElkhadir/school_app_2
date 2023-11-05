<?php

namespace Modules\Education\Transformers;

use App\Http\Resources\CityResource;
use App\Http\Resources\CountryResource;
use App\Http\Resources\LanguageResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Education\Entities\Student;

/** @mixin Student */
class StudentResource extends JsonResource
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
      'first_name' => $this->whenHas('first_name', $this->first_name),
      'last_name' => $this->whenHas('last_name', $this->last_name),
      'image' => $this->whenHas('image', $this->image),
      'rtl_first_name' => $this->whenHas('rtl_first_name', $this->rtl_first_name),
      'rtl_last_name' => $this->whenHas('rtl_last_name', $this->rtl_last_name),


      'country' => new CountryResource($this->whenLoaded('country')),
      'city' => new CityResource($this->whenLoaded('city')),

      'nationality' => new CountryResource($this->whenLoaded('nationality')),
      'birthCity' => new CityResource($this->whenLoaded('birthCity')),

      'nativeLanguage' => new LanguageResource($this->whenLoaded('nativeLanguage')),
      'secondLanguage' => new LanguageResource($this->whenLoaded('secondLanguage')),

      'cin' => $this->whenHas('cin', $this->cin),
      'cne' => $this->whenHas('cne', $this->cne),
      'birthday' => $this->whenHas('birthday', $this->birthday),
      'quotation' => $this->whenHas('quotation', $this->quotation),
      'insurance_name' => $this->whenHas('insurance_name', $this->insurance_name),
      'insurance_number' => $this->whenHas('insurance_number', $this->insurance_number),
      'old_school' => $this->whenHas('old_school', $this->old_school),
      'old_academy' => $this->whenHas('old_academy', $this->old_academy),
      'old_delegation' => $this->whenHas('old_delegation', $this->old_delegation),
      'notes' => $this->whenHas('notes', $this->notes),
      'how_he_knew_the_school' => $this->whenHas('how_he_knew_the_school', $this->how_he_knew_the_school),
      'has_scholarship' => $this->whenHas('has_scholarship', $this->has_scholarship),
      'scholarship_holder' => $this->whenHas('scholarship_holder', $this->scholarship_holder),


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
