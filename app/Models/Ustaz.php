<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ustaz extends Model
{
    /** @use HasFactory<\Database\Factories\UstazFactory> */
    use HasFactory;

    protected $table = 'ustazes';

    protected $fillable = [
        'name',
        'slug',
        'bio',
        'photo',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function derses(): HasMany
    {
        return $this->hasMany(Ders::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
