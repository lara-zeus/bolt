<?php

namespace LaraZeus\Bolt\Livewire;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\View\View;
use LaraZeus\Bolt\BoltPlugin;
use LaraZeus\Bolt\Models\Response;
use Livewire\Component;

class ListEntries extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
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
                        ->label(__('status'))
                        ->colors(config('zeus-bolt.models.FormsStatus')::pluck('key', 'color')->toArray())
                        ->icons(config('zeus-bolt.models.FormsStatus')::pluck('key', 'icon')->toArray())
                        ->grow(false),
                    TextColumn::make('form.name')
                        ->searchable('name')
                        ->label(__('Form Name'))
                        ->url(fn (Response $record): string => route('bolt.entry.show', $record)),
                ]),
                Stack::make([
                    TextColumn::make('updated_at')->label(__('Updated At'))->dateTime(),
                ]),
            ]);
    }

    public function render(): View
    {
        seo()
            ->title(__('My Responses') . ' ' . config('zeus.site_title', 'Laravel'))
            ->description(__('My Responses') . ' ' . config('zeus.site_description', 'Laravel'))
            ->site(config('zeus.site_title', 'Laravel'))
            ->rawTag('favicon', '<link rel="icon" type="image/x-icon" href="' . asset('favicon/favicon.ico') . '">')
            ->rawTag('<meta name="theme-color" content="' . config('zeus.site_color') . '" />')
            ->withUrl()
            ->twitter();

        return view(app('boltTheme') . '.list-entries')
            ->layout(config('zeus.layout'));
    }
}
