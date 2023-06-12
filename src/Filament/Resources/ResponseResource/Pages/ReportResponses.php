<?php

namespace LaraZeus\Bolt\Filament\Resources\ResponseResource\Pages;

use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\Page;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use LaraZeus\Bolt\Facades\Bolt;
use LaraZeus\Bolt\Filament\Resources\FormResource\Widgets\BetaNote;
use LaraZeus\Bolt\Filament\Resources\ResponseResource;
use LaraZeus\Bolt\Models\Form;

class ReportResponses extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static string $resource = ResponseResource::class;

    protected static string $view = 'zeus-bolt::filament.pages.reports.entries';

    protected static ?string $navigationIcon = 'heroicon-o-eye';

    public $form;

    public $form_id;

    protected $queryString = [
        'form_id',
    ];

    public function mount()
    {
        abort_unless(request()->filled('form_id'), 404);

        $this->form = Form::with(['fields'])->find(request('form_id'));
    }

    protected function getTitle(): string
    {
        return __('Entries Report');
    }

    protected function getHeaderWidgets(): array
    {
        return [
            BetaNote::class,
        ];
    }

    protected function getTableQuery(): Builder
    {
        return config('zeus-bolt.models.Response')::query()
            ->where('form_id', request('form_id'))
            ->with(['fieldsResponses']);
    }

    protected function getTableColumns(): array
    {
        $mainColumns = [
            ImageColumn::make('user.avatar')
                ->label(__('Avatar'))
                ->toggleable(),
            Tables\Columns\TextColumn::make('user.name')
                ->label(__('User Name'))
                ->searchable(),
            BadgeColumn::make('status')
                ->label(__('status'))
                ->enum(config('zeus-bolt.models.FormsStatus')::pluck('label', 'key')->toArray())
                ->colors(config('zeus-bolt.models.FormsStatus')::pluck('key', 'color')->toArray())
                ->icons(config('zeus-bolt.models.FormsStatus')::pluck('key', 'icon')->toArray())
                ->grow(false)
                ->searchable('status'),

            Tables\Columns\TextColumn::make('notes')
                ->toggleable(),
        ];

        foreach ($this->form->fields->sortBy('ordering') as $field) {
            $mainColumns[] = Tables\Columns\TextColumn::make('zeusData.' . $field->id)
                ->label($field->name)
                ->searchable(query: function (Builder $query, string $search): Builder {
                    return $query
                        ->whereHas('fieldsResponses', function ($query) use ($search) {
                            $query->where('response', 'like', '%' . $search . '%');
                        });
                })
                ->getStateUsing(fn(Model $record) => $this->getFieldResponseValue($record, $field))
                ->html()
                ->toggleable();
        }

        $mainColumns[] = Tables\Columns\TextColumn::make('created_at')
            ->toggleable();

        return $mainColumns;
    }

    public function getFieldResponseValue($record, $field)
    {
        $fieldResponse = $record->fieldsResponses->where('field_id', $field->id)->first();
        if ($fieldResponse === null) {
            return '';
        }

        return (new $fieldResponse->field->type)->getResponse($fieldResponse->field, $fieldResponse);
    }

    protected function getTableFilters(): array
    {
        return [
            SelectFilter::make('form')->relationship('form', 'name')->default(request('form_id', null)),
        ];
    }

    protected function getActions(): array
    {
        return [
            Action::make('brows')
                ->size('sm')
                ->visible(request()->filled('form_id'))
                ->label(__('Brows Entries'))
                ->url(fn(): string => ResponseResource::getUrl('brows') . '?form_id=' . request('form_id')),

            Action::make('list')
                ->size('sm')
                ->visible(request()->filled('form_id'))
                ->label(__('List Entries'))
                ->url(fn(): string => ResponseResource::getUrl() . '?form_id=' . request('form_id')),
        ];
    }
}
