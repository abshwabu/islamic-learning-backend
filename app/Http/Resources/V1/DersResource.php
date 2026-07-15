<?php

namespace App\Http\Resources\V1;

use App\Support\PublicStorageUrl;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Ders */
class DersResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'ustaz_id' => $this->ustaz_id,
            'topic_id' => $this->topic_id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'cover_image' => PublicStorageUrl::make($this->cover_image),
            'pdf_file' => PublicStorageUrl::make($this->pdf_file),
            'pdf_page_count' => $this->pdf_page_count,
            'sort_order' => $this->sort_order,
            'episodes' => EpisodeResource::collection($this->whenLoaded('episodes')),
        ];
    }
}
