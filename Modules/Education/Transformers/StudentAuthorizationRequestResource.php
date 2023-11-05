<?php

namespace Modules\Education\Transformers;

use App\Http\Resources\SchoolResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Education\Entities\StudentAuthorizationRequest;

/** @mixin StudentAuthorizationRequest * */
class StudentAuthorizationRequestResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param \Illuminate\Http\Request
   * @return array
   */
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'subscription' => new SubscriptionResource($this->whenLoaded('subscription')),
      'unity' => new UnityResource($this->whenLoaded('unity')),
      'authorized_by' => new UserResource($this->whenLoaded('authorizedBy')),
      'exempted' => $this->whenHas('exempted', $this->content),
      'content' => $this->whenHas('content', $this->content),
      'authorization_date' => $this->whenHas('authorization_date', $this->authorization_date),
      'file' => $this->whenHas('file', $this->file),
      'school' => new SchoolResource($this->whenLoaded('school')),
    ];
  }
}
