<?php

namespace LaraZeus\Bolt\Http\Livewire;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use LaraZeus\Bolt\Models\Response;
use Livewire\Component;

class ListEntries extends Component implements HasTable, HasForms
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                config('zeus-bolt.models.Response')::query()->where('user_id', auth()->user()->id)
            )
            ->columns([
                Split::make([
                    TextColumn::make('status')
                        ->badge()
                        ->label(__('status'))
                        // todo
                        //->enums(config('zeus-bolt.models.FormsStatus')::pluck('label', 'key')->toArray())
                        ->colors(config('zeus-bolt.models.FormsStatus')::pluck('key', 'color')->toArray())
                        ->icons(config('zeus-bolt.models.FormsStatus')::pluck('key', 'icon')->toArray())
                        ->grow(false),
                    TextColumn::make('form.name')
                        //->searchable('name')
                        ->label(__('Form Name'))
                        ->url(fn (Response $record): string => route('bolt.entry.show', $record)),
                ]),
                Stack::make([
                    TextColumn::make('updated_at')->label(__('Updated At'))->dateTime(),
                ]),
            ]);
    }

    /* protected function getTableContentGrid(): ?array
     {
         return [
             'sm' => 1,
             'md' => 2,
             'xl' => 3,
         ];
     }*/

    public function render()
    {
        seo()
            ->title(__('My Responses') . ' ' . config('zeus-bolt.site_title', 'Laravel'))
            ->description(__('My Responses') . ' ' . config('zeus-bolt.site_description', 'Laravel'))
            ->site(config('zeus-bolt.site_title', 'Laravel'))
            ->rawTag('favicon', '<link rel="icon" type="image/x-icon" href="' . asset('favicon/favicon.ico') . '">')
            ->rawTag('<meta name="theme-color" content="' . config('zeus-bolt.site_color') . '" />')
            ->withUrl()
            ->twitter();

        return view(app('boltTheme') . '.list-entries')
            ->layout(config('zeus.layout'));
    }
}
