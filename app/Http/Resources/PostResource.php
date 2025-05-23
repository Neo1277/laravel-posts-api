<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
//use App\Http\Resources\CategoryResource;
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
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'short_text' => $this->short_text,
            'large_text' => $this->large_text,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'category' => $this->category->name,
            // source: https://stackoverflow.com/a/47710930
            //'category'    => new CategoryResource($this->category),
            // When many source: https://stackoverflow.com/a/56445220
        ];
    }
}
