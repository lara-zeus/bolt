<?php

namespace LaraZeus\Bolt\Filament\Resources;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Actions\LinkAction;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use LaraZeus\Bolt\Filament\Resources\FormResource\Pages;
use LaraZeus\Bolt\Filament\Resources\FormResource\RelationManagers\ResponsesRelationManager;
use LaraZeus\Bolt\Filament\Resources\FormResource\RelationManagers\SectionsRelationManager;
use LaraZeus\Bolt\Models\Form as ZeusForm;

class FormResource extends Resource
{
    protected static ?string $model = ZeusForm::class;
    protected static ?string $navigationIcon = 'clarity-form-line';
    protected static ?int $navigationSort = 1;

    protected static function getNavigationGroup() : ?string
    {
        return __('Bolt');
    }

    public static function getLabel() : string
    {
        return __('zeus-bolt::common.form');
    }

    public static function getPluralLabel() : string
    {
        return __('zeus-bolt::common.forms');
    }

    protected static function getNavigationLabel() : string
    {
        return __('zeus-bolt::common.forms');
    }

    public static function form(Form $form) : Form
    {
        return $form
            ->schema([
                TextInput::make('user_id')->required(),
                TextInput::make('name')->required()->maxLength(255),
                TextInput::make('slug')->required()->maxLength(255),
                TextInput::make('layout')->required()->maxLength(255),
                TextInput::make('ordering')->required(),
                Toggle::make('is_active')->required(),
                Textarea::make('desc')->maxLength(65535),
                Textarea::make('details')->maxLength(65535),
                Textarea::make('options')->maxLength(65535),
                DateTimePicker::make('start_date'),
                DateTimePicker::make('end_date'),
            ]);
    }

    public static function table(Table $table) : Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                //TextColumn::make('slug'),
                TextColumn::make('ordering'),
                BooleanColumn::make('is_active'),
                TextColumn::make('start_date')->dateTime(),
                TextColumn::make('end_date')->dateTime(),
            ])
            ->filters([
                //
            ])
            //
            ->pushActions([
                LinkAction::make('open')
                    ->icon('heroicon-o-external-link')
                    ->tooltip('Show the Form')
                    ->url(fn(ZeusForm $record) : string => route('bolt.user.form.show', $record))
                    ->openUrlInNewTab(),

                LinkAction::make('entries')
                    ->icon('heroicon-o-external-link')
                    ->tooltip('View All Entries')
                    ->url(fn(ZeusForm $record) : string => url('admin/responses?form_id=' . $record->id)),
            ]);
    }

    public static function getRelations() : array
    {
        return [
            ResponsesRelationManager::class,
            SectionsRelationManager::class,
        ];
    }

    public static function getPages() : array
    {
        return [
            'index'  => Pages\ListForms::route('/'),
            'create' => Pages\CreateForm::route('/create'),
            'edit'   => Pages\EditForm::route('/{record}/edit'),
            'view'   => Pages\ViewForm::route('/{record}'),
        ];
    }
}
