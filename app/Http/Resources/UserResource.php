<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\User */
class UserResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    return [
      'id' => $this->whenHas('id'),
      'first_name' => $this->whenHas('first_name'),
      'last_name' => $this->whenHas('last_name'),
      'middle_name' => $this->whenHas('middle_name'),
      'name' => $this->whenAppended('name'),
      'email' => $this->whenHas('email'),
      'email_verified_at' => $this->whenHas('email_verified_at'),
      'status' => $this->whenHas('status'),
      'theme' => $this->whenHas('theme', $this->theme?->toArray()),
      'language' => LanguageResource::make($this->whenLoaded('language')),
      'profile' => ProfileResource::make($this->whenLoaded('profile')),
    ];
  }
}
