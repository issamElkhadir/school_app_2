<?php

namespace Modules\Education\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Education\Entities\Branch;
use Modules\Education\Entities\SubjectSequence;

/** @mixin SubjectSequence */
class SubjectSequenceResource extends JsonResource
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
      'content' => $this->whenHas('content', $this->content),
      'subject' => new SubjectResource($this->whenLoaded('subject')),
      'nbh' => $this->whenHas('nbh', $this->nbh),
      'status' => $this->whenHas('status', $this->status),
      'created_at' => $this->whenHas('created_at', $this->created_at),
      'updated_at' => $this->whenHas('updated_at', $this->updated_at),
    ];
  }
}
