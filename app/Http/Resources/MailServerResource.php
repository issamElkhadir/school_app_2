<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\MailServer */
class MailServerResource extends JsonResource
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
      'name' => $this->whenHas('name'),
      'priority' => $this->whenHas('priority'),
      'active' => $this->whenHas('active'),
      'username' => $this->whenHas('username'),
      'smtp_host' => $this->whenHas('smtp_host'),
      'smtp_port' => $this->whenHas('smtp_port'),
      'smtp_encryption' => $this->whenHas('smtp_encryption'),
    ];
  }
}
