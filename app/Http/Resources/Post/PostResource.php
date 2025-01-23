<?php

namespace App\Http\Resources\Post;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "description" => $this->description,
            "location" => $this->location,
            "imageLink" => $this->imageLink ?? null,
            "price" => $this->price,
            "kitchens" => $this->kitchens,
            "rooms" => $this->rooms,
            "bedrooms" => $this->bedrooms,
            "bathrooms" => $this->bathrooms,
            "city" => $this->city,
            "category" => $this->category,

        ];
    }
}
