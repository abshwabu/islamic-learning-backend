<?php

namespace App\Filament\Support;

use Filament\Forms;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Str;

class SlugFromField
{
    /**
     * @return array<int, Forms\Components\Component>
     */
    public static function nameSlugFields(string $nameLabel = 'Name', string $nameField = 'name'): array
    {
        return [
            Forms\Components\TextInput::make($nameField)
                ->label($nameLabel)
                ->required()
                ->maxLength(255)
                ->live(onBlur: true)
                ->afterStateUpdated(function (Get $get, Set $set, ?string $state, ?string $old, string $operation): void {
                    $slug = $get('slug');

                    if ($operation === 'edit' && filled($slug) && $slug !== Str::slug($old ?? '')) {
                        return;
                    }

                    if (filled($state)) {
                        $set('slug', Str::slug($state));
                    }
                }),
            Forms\Components\TextInput::make('slug')
                ->required()
                ->maxLength(255)
                ->unique(ignoreRecord: true),
        ];
    }

    /**
     * @return array<int, Forms\Components\Component>
     */
    public static function titleSlugFields(): array
    {
        return self::nameSlugFields('Title', 'title');
    }
}
