<?php

namespace LaraZeus\Bolt\Filament\Resources\ResponseResource\Pages;

use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use Closure;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Resources\Pages\Page;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use LaraZeus\Bolt\Filament\Resources\ResponseResource;
use LaraZeus\Bolt\Models\Form;
use LaraZeus\Bolt\Models\FormsStatus;
use LaraZeus\Bolt\Models\Response;

class ReportResponses extends Page implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;
    use \LaraZeus\Bolt\Concerns\EntriesAction;

    protected static string $resource = ResponseResource::class;

    protected static string $view = 'zeus::filament.pages.reports.entries';

    protected static ?string $navigationIcon = 'heroicon-o-eye';

    public $form;

    public int $form_id = 0;

    protected $queryString = [
        'form_id',
    ];

    public function table(Table $table): Table
    {
        $mainColumns = [
            ImageColumn::make('user.avatar')
                ->label(__('Avatar'))
                ->toggleable(),
            TextColumn::make('user.name')
                ->label(__('User Name'))
                ->searchable(),
            TextColumn::make('status')
                ->badge()
                ->label(__('status'))
                //->enum(config('zeus-bolt.models.FormsStatus')::pluck('label', 'key')->toArray())
                ->colors(config('zeus-bolt.models.FormsStatus')::pluck('key', 'color')->toArray())
                ->icons(config('zeus-bolt.models.FormsStatus')::pluck('key', 'icon')->toArray())
                ->grow(false)
                ->searchable('status'),

            TextColumn::make('notes')->toggleable(),
        ];

        foreach ($this->form->fields->sortBy('ordering') as $field) {
            $mainColumns[] = TextColumn::make('zeusData.'.$field->id)
                ->label($field->name)
                ->searchable(query: function (Builder $query, string $search): Builder {
                    return $query
                        ->whereHas('fieldsResponses', function ($query) use ($search) {
                            $query->where('response', 'like', '%'.$search.'%');
                        });
                })
                ->getStateUsing(fn(Model $record) => $this->getFieldResponseValue($record, $field))
                ->html()
                ->toggleable();
        }

        $mainColumns[] = TextColumn::make('created_at')->toggleable();

        return $table
            ->query(
                config('zeus-bolt.models.Response')::query()
                    ->where('form_id', $this->form_id)
                    ->with(['fieldsResponses'])
            )
            ->columns($mainColumns)
            ->filters([
                SelectFilter::make('form')->relationship('form', 'name')->default(request('form_id', null)),
                SelectFilter::make('status')
                    ->options(FormsStatus::query()->pluck('label', 'key'))
                    ->label(__('Status')),
            ])
            ->actions([
                ActionGroup::make([
                    Action::make('brows')
                        ->icon('heroicon-o-eye')
                        ->visible($this->form_id !== 0)
                        ->label(__('Brows Entries'))
                        ->url(fn(): string => ResponseResource::getUrl('brows').'?form_id='.request('form_id')),
                    Action::make('list')
                        ->icon('heroicon-o-bars-4')
                        ->visible($this->form_id !== 0)
                        ->label(__('List Entries'))
                        ->url(fn(): string => ResponseResource::getUrl().'?form_id='.$this->form_id),
                    Action::make('report')
                        ->icon('heroicon-o-document-chart-bar')
                        ->visible($this->form_id !== 0)
                        ->label(__('Entries Report'))
                        ->url(fn(): string => ResponseResource::getUrl('report').'?form_id='.$this->form_id),
                ])
            ])
            ->recordUrl(
                fn(Model $record): string => ResponseResource::getUrl('view', ['record' => $record]),
            );
    }

    public function mount()
    {
        abort_unless(request()->filled('form_id'), 404);

        $this->form_id = request('form_id', 0);
        $this->form = Form::with(['fields'])->find($this->form_id);
    }

    public function getTitle(): string
    {
        return __('Entries Report');
    }

    public function getFieldResponseValue($record, $field)
    {
        $fieldResponse = $record->fieldsResponses->where('field_id', $field->id)->first();
        if ($fieldResponse === null) {
            return '';
        }

        return (new $fieldResponse->field->type)->getResponse($fieldResponse->field, $fieldResponse);
    }
}
