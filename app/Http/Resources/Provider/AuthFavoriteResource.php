<?php

namespace App\Http\Resources\Provider;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthFavoriteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return new ProviderServiceFavoriteResource($this->whenLoaded('providerService'));

    }
}
