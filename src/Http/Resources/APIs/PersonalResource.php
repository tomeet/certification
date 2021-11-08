<?php

namespace Tomeet\Certification\Http\Resources\APIs;

use Illuminate\Http\Resources\Json\JsonResource;

class PersonalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
