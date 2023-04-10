<?php

namespace App\Http\Resources\Provider;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
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
            'status_s' => $this->status,
            'status_a' => $this->status_a,
            'slug' => $this->slug,
            'category_name' => $this->service->category->category_name,
            'service_name' => $this->service->service_name,
            'price_number' => $this->whenLoaded('providerServicePrice')->first()->price_number ?? null,
            'subRows' => $this->whenLoaded('providerServicePhone'),
        ];
    }
}
