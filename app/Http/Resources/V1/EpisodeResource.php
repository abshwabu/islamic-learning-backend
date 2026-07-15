<?php

namespace App\Http\Resources\V1;

use App\Support\PublicStorageUrl;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Episode */
class EpisodeResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'ders_id' => $this->ders_id,
            'title' => $this->title,
            'audio_file' => PublicStorageUrl::make($this->audio_file),
            'duration_seconds' => $this->duration_seconds,
            'start_page' => $this->start_page,
            'end_page' => $this->end_page,
            'sort_order' => $this->sort_order,
        ];
    }
}
