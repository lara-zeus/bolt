<?php

namespace LaraZeus\Bolt\Filament\Actions;

use Filament\Actions\Concerns\CanReplicateRecords;
use Filament\Actions\Contracts\ReplicatesRecords;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Set;
use Filament\Support\Facades\FilamentIcon;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Str;
use LaraZeus\Bolt\Models\Form as ZeusForm;

class ReplicateFormAction extends Action implements ReplicatesRecords
{
    use CanReplicateRecords {
        CanReplicateRecords::setUp as baseSetUp;
    }

    protected function setUp(): void
    {
        $this->baseSetUp();

        $this->icon(FilamentIcon::resolve('actions::replicate-action') ?? 'heroicon-m-square-2-stack')
            ->label(__('Replicate'))
            ->excludeAttributes(['name', 'slug', 'responses_exists', 'responses_count'])
            ->form([
                TextInput::make('name.' . app()->getLocale())
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->label(__('Form Name'))
                    ->afterStateUpdated(function (Set $set, $state) {
                        $set('slug', Str::slug($state));
                    }),
                TextInput::make('slug')
                    ->formatStateUsing(fn ($record) => $record->slug . '-' . rand(1, 99))
                    ->required()
                    ->maxLength(255)
                    ->rules(['alpha_dash'])
                    ->unique(ignoreRecord: true)
                    ->label(__('Form Slug')),
            ])
            ->beforeReplicaSaved(function (ZeusForm $replica, ZeusForm $record, array $data): void {
                $repForm = $replica->fill($data);
                $repForm->save();
                $formID = $repForm->id;
                $record->sections->each(function ($item) use ($formID) {
                    $repSec = $item->replicate()->fill(['form_id' => $formID]);
                    $repSec->save();
                    $sectionID = $repSec->id;
                    $item->fields->each(function ($item) use ($sectionID) {
                        $repField = $item->replicate()->fill(['section_id' => $sectionID]);
                        $repField->save();
                    });
                });
            });
    }
}
