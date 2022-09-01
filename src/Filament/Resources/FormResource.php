<?php

namespace LaraZeus\Bolt\Filament\Resources;

use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use LaraZeus\Bolt\Filament\Resources\FormResource\Pages;
use LaraZeus\Bolt\Filament\Resources\FormResource\Schemata;
use LaraZeus\Bolt\Filament\Resources\FormResource\Widgets\BetaNote;
use LaraZeus\Bolt\Models\Form as ZeusForm;
use Illuminate\Database\Eloquent\Builder;

class FormResource extends BoltResource
{
    use Schemata;

    protected static ?string $model = ZeusForm::class;
    protected static ?string $navigationIcon = 'clarity-form-line';
    protected static ?int $navigationSort = 1;
    protected static ?string $recordTitleAttribute = 'name';

    public static function getGloballySearchableAttributes() : array
    {
        return [ 'name', 'slug' ];
    }

    protected static function getNavigationBadge() : ?string
    {
        return (string) ZeusForm::query()->count();
    }

    protected static function getNavigationGroup() : ?string
    {
        return __('Bolt');
    }

    public static function getLabel() : string
    {
        return __('Form');
    }

    public static function getPluralLabel() : string
    {
        return __('Forms');
    }

    protected static function getNavigationLabel() : string
    {
        return __('Forms');
    }

    public static function form(Form $form) : Form
    {
        return $form->schema(static::getMainFormSchema());
    }

    public static function table(Table $table) : Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable()->label(__('Form Name')),
                TextColumn::make('category.name')->label(__('Category'))->sortable(),
                BooleanColumn::make('is_active')->label(__('Is Active'))->sortable(),
                TextColumn::make('start_date')->dateTime()->searchable()->sortable()->label(__('Start Date')),
                TextColumn::make('end_date')->dateTime()->searchable()->sortable()->label(__('End Date')),
                BooleanColumn::make('responses_exists')->exists('responses')->label(__('Responses Exists'))->sortable(),
                TextColumn::make('responses_count')->counts('responses')->label(__('Responses Count'))->sortable(),
            ])
            ->appendActions([
                Action::make('entries')
                    ->label(__('Entries'))
                    ->icon('clarity-data-cluster-line')
                    ->tooltip(__('view all entries'))
                    ->url(fn(ZeusForm $record) : string => url('admin/responses?form_id=' . $record->id)),

                Action::make('open')
                    ->label(__('Open'))
                    ->icon('heroicon-o-external-link')
                    ->tooltip(__('open form'))
                    ->url(fn(ZeusForm $record) : string => route('bolt.user.form.show', $record))
                    ->openUrlInNewTab(),
            ])->filters([
                Filter::make('is_active')
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->where('is_active', true))
                    ->label(__('Is Active')),
            ]);
    }

    public static function getPages() : array
    {
        return [
            'index'  => Pages\ListForms::route('/'),
            'create' => Pages\CreateForm::route('/create'),
            'edit'   => Pages\EditForm::route('/{record}/edit'),
        ];
    }

    public static function getWidgets() : array
    {
        return [
            BetaNote::class,
        ];
    }
}
