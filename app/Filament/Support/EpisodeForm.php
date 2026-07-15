<?php

namespace App\Filament\Support;

use App\Models\Ders;
use App\Filament\Support\UploadLimits;
use App\Services\AudioDurationService;
use Filament\Forms;
use Filament\Forms\Get;
use Filament\Forms\Set;

class EpisodeForm
{
    /**
     * @return array<int, Forms\Components\Component>
     */
    public static function schema(?int $dersId = null, bool $includeDersSelect = false): array
    {
        $resolveDersId = function (Get $get) use ($dersId, $includeDersSelect): ?int {
            if ($includeDersSelect) {
                return $get('ders_id');
            }

            return $dersId;
        };

        $fields = [];

        if ($includeDersSelect) {
            $fields[] = Forms\Components\Select::make('ders_id')
                ->relationship('ders', 'title')
                ->required()
                ->live()
                ->searchable()
                ->preload();
        }

        return [
            ...$fields,
            Forms\Components\TextInput::make('title')
                ->required()
                ->maxLength(255),
            Forms\Components\FileUpload::make('audio_file')
                ->label('Audio')
                ->disk('public')
                ->directory('episodes')
                ->required()
                ->maxSize(UploadLimits::AUDIO_MAX_KB)
                ->acceptedFileTypes([
                    'audio/mpeg',
                    'audio/mp3',
                    'audio/wav',
                    'audio/x-wav',
                    'audio/ogg',
                    'audio/aac',
                    'audio/mp4',
                    'audio/x-m4a',
                    'audio/webm',
                ])
                ->rules([
                    'mimetypes:audio/mpeg,audio/mp3,audio/wav,audio/x-wav,audio/ogg,audio/aac,audio/mp4,audio/x-m4a,audio/webm',
                ])
                ->validationMessages([
                    'max' => 'The audio file must not be larger than 30 MB.',
                ])
                ->helperText('Maximum file size: 30 MB.')
                ->afterStateUpdated(function ($state, Set $set): void {
                    $path = self::normalizeUploadPath($state);

                    if (blank($path)) {
                        return;
                    }

                    $duration = app(AudioDurationService::class)->getDurationSeconds($path);

                    if ($duration !== null) {
                        $set('duration_seconds', $duration);
                    }
                })
                ->columnSpanFull(),
            Forms\Components\TextInput::make('duration_seconds')
                ->label('Duration (seconds)')
                ->numeric()
                ->disabled()
                ->dehydrated(),
            Forms\Components\TextInput::make('start_page')
                ->label('Start page')
                ->numeric()
                ->required()
                ->minValue(1)
                ->maxValue(function (Get $get) use ($resolveDersId): int {
                    $ders = Ders::query()->find($resolveDersId($get));

                    return $ders?->pdf_page_count ?? PHP_INT_MAX;
                })
                ->helperText('Must be less than or equal to the Ders PDF page count.'),
            Forms\Components\Placeholder::make('end_page_info')
                ->label('End page')
                ->content('Computed automatically from the next episode or PDF page count.'),
            Forms\Components\TextInput::make('sort_order')
                ->numeric()
                ->default(function () use ($dersId): int {
                    if (! $dersId) {
                        return 1;
                    }

                    return (int) (Ders::query()->find($dersId)?->episodes()->max('sort_order') ?? 0) + 1;
                }),
            Forms\Components\Toggle::make('is_published')
                ->default(true),
        ];
    }

    public static function normalizeUploadPath(mixed $state): ?string
    {
        if (blank($state)) {
            return null;
        }

        if (is_array($state)) {
            return $state[0] ?? null;
        }

        return (string) $state;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public static function processAudioDuration(array $data): array
    {
        $path = self::normalizeUploadPath($data['audio_file'] ?? null);

        if ($path && empty($data['duration_seconds'])) {
            $duration = app(AudioDurationService::class)->getDurationSeconds($path);

            if ($duration !== null) {
                $data['duration_seconds'] = $duration;
            }
        }

        return $data;
    }
}
