<?php

namespace App\Http\Resources\Provider;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthProviderServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name_brand' => $this->name_brand,
            'day_of_week' => $this->day_of_week,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'details' => $this->details,
            'status' => $this->status,
            'status_a' => $this->status_a,
            'slug' => $this->slug,
            'service' => [
                'id' => $this->service->id,
                'service_name' => $this->service->service_name,
                'category' => [
                    'id' => $this->service->category->id,
                    'category_name' => $this->service->category->category_name,
                ],
            ],
            'provider_service_phone' => $this->whenLoaded('providerServicePhone'),
            'provider_service_price' => $this->whenLoaded('providerServicePrice'),
            'ratingStatus' => $this->provider_id !== auth('sanctum')->id() ? true : false,
            'ratings_avg_rating' => $this->ratings_avg_rating,
            'ratings_count' => $this->ratings_count,
        ];
    }
}
