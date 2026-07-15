<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Episode extends Model
{
    /** @use HasFactory<\Database\Factories\EpisodeFactory> */
    use HasFactory;

    protected $fillable = [
        'ders_id',
        'title',
        'audio_file',
        'duration_seconds',
        'start_page',
        'end_page',
        'sort_order',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'duration_seconds' => 'integer',
            'start_page' => 'integer',
            'end_page' => 'integer',
            'sort_order' => 'integer',
            'is_published' => 'boolean',
        ];
    }

    public function ders(): BelongsTo
    {
        return $this->belongsTo(Ders::class);
    }
}
