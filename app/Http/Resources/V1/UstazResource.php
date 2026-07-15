<?php

namespace App\Http\Resources\V1;

use App\Support\PublicStorageUrl;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Ustaz */
class UstazResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'bio' => $this->bio,
            'photo' => PublicStorageUrl::make($this->photo),
            'sort_order' => $this->sort_order,
        ];
    }
}
