<?php

namespace LaraZeus\Bolt\Livewire;

use Filament\Pages\Page;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\View\View;
use LaraZeus\Bolt\Models\Response;

class ListEntries extends Page implements HasTable
{
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                config('zeus-bolt.models.Response')::query()->where('user_id', auth()->user()->id)
            )
            ->contentGrid([
                'sm' => 1,
                'md' => 2,
                'xl' => 3,
            ])
            ->columns([
                Split::make([
                    TextColumn::make('status')
                        ->badge()
                        ->label(__('zeus-bolt::forms.status'))
                        ->grow(false),
                    TextColumn::make('form.name')
                        ->searchable('name')
                        ->label(__('zeus-bolt::forms.options.tabs.title.name'))
                        ->url(fn (Response $record): string => route('bolt.entry.show', $record)),
                ]),
                Stack::make([
                    TextColumn::make('updated_at')
                        ->label(__('zeus-bolt::forms.updated_at'))
                        ->dateTime(),
                ]),
            ]);
    }

    public function render(): View
    {
        seo()
            ->title(__('zeus-bolt::response.my_responses') . ' ' . config('zeus.site_title', 'Laravel'))
            ->description(__('zeus-bolt::response.my_responses') . ' ' . config('zeus.site_description', 'Laravel'))
            ->site(config('zeus.site_title', 'Laravel'))
            ->rawTag('favicon', '<link rel="icon" type="image/x-icon" href="' . asset('favicon/favicon.ico') . '">')
            ->rawTag('<meta name="theme-color" content="' . config('zeus.site_color') . '" />')
            ->withUrl()
            ->twitter();

        return view(app('boltTheme') . '.list-entries')
            ->layout(config('zeus.layout'));
    }
}
