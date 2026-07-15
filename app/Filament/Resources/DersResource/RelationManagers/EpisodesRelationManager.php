<?php

namespace App\Filament\Resources\DersResource\RelationManagers;

use App\Filament\Support\EpisodeForm;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class EpisodesRelationManager extends RelationManager
{
    protected static string $relationship = 'episodes';

    public function form(Form $form): Form
    {
        return $form
            ->schema(EpisodeForm::schema(
                dersId: $this->getOwnerRecord()->getKey(),
            ));
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('duration_seconds')
                    ->label('Duration')
                    ->formatStateUsing(fn (?int $state): string => $state ? gmdate('H:i:s', $state) : '—'),
                Tables\Columns\TextColumn::make('start_page'),
                Tables\Columns\TextColumn::make('end_page'),
                Tables\Columns\TextColumn::make('sort_order'),
                Tables\Columns\IconColumn::make('is_published')
                    ->boolean(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(fn (array $data): array => $this->prepareEpisodeData($data)),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->mutateFormDataUsing(fn (array $data): array => EpisodeForm::processAudioDuration($data)),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function prepareEpisodeData(array $data): array
    {
        $data['ders_id'] = $this->getOwnerRecord()->getKey();

        if (empty($data['sort_order'])) {
            $data['sort_order'] = (int) ($this->getOwnerRecord()->episodes()->max('sort_order') ?? 0) + 1;
        }

        return EpisodeForm::processAudioDuration($data);
    }
}
