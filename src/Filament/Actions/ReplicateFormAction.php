<?php

namespace LaraZeus\Bolt\Filament\Actions;

use Filament\Actions\Concerns\CanCustomizeProcess;
use Filament\Actions\ReplicateAction;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Support\Str;
use LaraZeus\Bolt\Models\Form as ZeusForm;

class ReplicateFormAction extends ReplicateAction
{
    use CanCustomizeProcess;

    protected function setUp(): void
    {
        parent::setUp();

        $this->icon(FilamentIcon::resolve('actions::replicate-action') ?? 'heroicon-m-square-2-stack')
            ->label(__('zeus-bolt::forms.actions.replicate'))
            ->excludeAttributes(['name', 'slug', 'responses_exists', 'responses_count'])
            ->schema([
                TextInput::make('name.' . app()->getLocale())
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->label(__('zeus-bolt::forms.options.tabs.title.name'))
                    ->afterStateUpdated(function (Set $set, $state) {
                        $set('slug', Str::slug($state));
                    }),
                TextInput::make('slug')
                    ->formatStateUsing(fn ($record) => $record->slug . '-' . rand(1, 99))
                    ->required()
                    ->maxLength(255)
                    ->rules(['alpha_dash'])
                    ->unique()
                    ->label(__('zeus-bolt::forms.options.tabs.title.slug')),
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
