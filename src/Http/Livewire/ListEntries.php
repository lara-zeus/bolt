<?php

namespace LaraZeus\Bolt\Http\Livewire;

use Filament\Tables;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
use LaraZeus\Bolt\Models\Response;
use Livewire\Component;

class ListEntries extends Component implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected function getTableQuery(): Builder
    {
        return config('zeus-bolt.models.Response')::query()->where('user_id', auth()->user()->id);
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('form.name'),
            Tables\Columns\BadgeColumn::make('status')
                ->enum(config('zeus-bolt.models.FormsStatus')::pluck('label', 'key')->toArray())
                ->colors(config('zeus-bolt.models.FormsStatus')::pluck('key', 'color')->toArray())
                ->icons(config('zeus-bolt.models.FormsStatus')::pluck('key', 'icon')->toArray()),

            Tables\Columns\TextColumn::make('updated_at')->dateTime(),
        ];
    }

    protected function getTableFilters(): array
    {
        return [];
    }

    protected function getTableActions(): array
    {
        return [
            Action::make('view')
                ->url(fn (Response $record): string => route('bolt.user.entry.show', $record)),
        ];
    }

    public function render()
    {
        seo()
            ->title('My Responses ' . config('zeus-bolt.site_title', 'Laravel'))
            ->description('My Responses ' . config('zeus-bolt.site_description', 'Laravel'))
            ->site(config('zeus-bolt.site_title', 'Laravel'))
            ->rawTag('favicon', '<link rel="icon" type="image/x-icon" href="' . asset('favicon/favicon.ico') . '">')
            ->rawTag('<meta name="theme-color" content="' . config('zeus-bolt.site_color') . '" />')
            ->withUrl()
            ->twitter();

        return view(app('bolt-theme') . '.list-entries')
            //->with('tickets', config('zeus-bolt.models.Response')::where('user_id', auth()->user()->id)->get())
            ->layout(config('zeus-bolt.layout'));
    }
}
