<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ders extends Model
{
    /** @use HasFactory<\Database\Factories\DersFactory> */
    use HasFactory;

    protected $table = 'derses';

    protected $fillable = [
        'ustaz_id',
        'topic_id',
        'title',
        'slug',
        'description',
        'cover_image',
        'pdf_file',
        'pdf_page_count',
        'sort_order',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'pdf_page_count' => 'integer',
            'sort_order' => 'integer',
            'is_published' => 'boolean',
        ];
    }

    public function ustaz(): BelongsTo
    {
        return $this->belongsTo(Ustaz::class);
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function episodes(): HasMany
    {
        return $this->hasMany(Episode::class)->orderBy('sort_order');
    }
}
