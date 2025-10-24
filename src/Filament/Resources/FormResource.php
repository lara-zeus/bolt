<?php

namespace LaraZeus\Bolt\Filament\Resources;

use BackedEnum;
use Closure;
use Exception;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Pages\Enums\SubNavigationPosition;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use LaraZeus\Bolt\BoltPlugin;
use LaraZeus\Bolt\Concerns\HasOptions;
use LaraZeus\Bolt\Concerns\Schemata;
use LaraZeus\Bolt\Facades\Bolt;
use LaraZeus\Bolt\Filament\Actions\ReplicateFormAction;
use LaraZeus\Bolt\Filament\Resources\FormResource\Pages\BrowseResponses;
use LaraZeus\Bolt\Filament\Resources\FormResource\Pages\CreateForm;
use LaraZeus\Bolt\Filament\Resources\FormResource\Pages\EditForm;
use LaraZeus\Bolt\Filament\Resources\FormResource\Pages\ListForms;
use LaraZeus\Bolt\Filament\Resources\FormResource\Pages\ManageResponses;
use LaraZeus\Bolt\Filament\Resources\FormResource\Pages\ViewForm;
use LaraZeus\Bolt\Filament\Resources\FormResource\Pages\ViewResponse;
use LaraZeus\Bolt\Filament\Resources\FormResource\Widgets\FormOverview;
use LaraZeus\Bolt\Filament\Resources\FormResource\Widgets\ResponsesPerFields;
use LaraZeus\Bolt\Filament\Resources\FormResource\Widgets\ResponsesPerMonth;
use LaraZeus\Bolt\Filament\Resources\FormResource\Widgets\ResponsesPerStatus;
use LaraZeus\Bolt\Models\Form as ZeusForm;
use LaraZeus\BoltPro\Livewire\PrefilledForm;
use LaraZeus\BoltPro\Livewire\ShareForm;
use LaraZeus\BoltPro\Widgets\ResponsesPerCollection;
use LaraZeus\Helen\Actions\ShortUrlAction;
use LaraZeus\Helen\HelenServiceProvider;
use LaraZeus\ListGroup\Infolists\ListEntry;

class FormResource extends BoltResource
{
    use HasOptions;
    use Schemata;

    protected static string | BackedEnum | null $navigationIcon = 'tabler-file-description';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    protected static Closure | array | null $boltFormSchema = null;

    protected static ?SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function getModel(): string
    {
        return BoltPlugin::getModel('Form');
    }

    public static function getNavigationBadge(): ?string
    {
        if (! BoltPlugin::getNavigationBadgesVisibility(self::class)) {
            return null;
        }

        return (string) BoltPlugin::getModel('Form')::query()->count();
    }

    public static function getModelLabel(): string
    {
        return __('zeus-bolt::forms.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('zeus-bolt::forms.plural_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('zeus-bolt::forms.navigation_label');
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('name')
                            ->label(__('zeus-bolt::forms.options.tabs.title.name')),

                        ListEntry::make('slug_url')
                            ->visible(fn (ZeusForm $record) => $record->extensions !== null)
                            ->heading(__('zeus-bolt::forms.options.tabs.title.links'))
                            ->list(),

                        TextEntry::make('slug')
                            ->label(__('zeus-bolt::forms.options.tabs.title.slug'))
                            ->url(
                                fn (ZeusForm $record) => route(
                                    BoltPlugin::get()->getRouteNamePrefix() . 'bolt.form.show',
                                    ['slug' => $record->slug]
                                )
                            )
                            ->visible(fn (ZeusForm $record) => $record->extensions === null)
                            ->icon('heroicon-o-arrow-top-right-on-square')
                            ->openUrlInNewTab(),

                        TextEntry::make('description')
                            ->label(__('zeus-bolt::forms.options.tabs.details.description')),
                        IconEntry::make('is_active')
                            ->label(__('zeus-bolt::forms.options.tabs.display.is_active'))
                            ->icon(fn (string $state): string => match ($state) {
                                '0' => 'tabler-circle-x',
                                default => 'tabler-circle-check',
                            })
                            ->color(fn (string $state): string => match ($state) {
                                '0' => 'warning',
                                '1' => 'success',
                                default => 'gray',
                            }),

                        TextEntry::make('start_date')
                            ->label(__('zeus-bolt::forms.options.tabs.advanced.start_date'))
                            ->dateTime(),
                        TextEntry::make('end_date')
                            ->label(__('zeus-bolt::forms.options.tabs.advanced.end_date'))
                            ->dateTime(),
                    ])
                    ->columns(),
            ]);
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components(static::$boltFormSchema ?? static::getMainFormSchema());
    }

    public function getBoltFormSchema(): array | Closure | null
    {
        return static::$boltFormSchema;
    }

    public static function getBoltFormSchemaUsing(array | Closure | null $form): void
    {
        static::$boltFormSchema = $form;
    }

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('ordering')
            ->columns([
                TextColumn::make('id')
                    ->sortable()
                    ->label(__('zeus-bolt::forms.form_id'))
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('name')
                    ->forceSearchCaseInsensitive()
                    ->searchable()
                    ->sortable()
                    ->label(__('zeus-bolt::forms.options.tabs.title.name'))
                    ->toggleable(),
                TextColumn::make('category.name')
                    ->forceSearchCaseInsensitive()
                    ->searchable()
                    ->label(__('zeus-bolt::forms.options.tabs.title.category.label'))
                    ->sortable()
                    ->toggleable(),
                IconColumn::make('is_active')
                    ->boolean()
                    ->label(__('zeus-bolt::forms.options.tabs.display.is_active'))
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('start_date')
                    ->dateTime()
                    ->searchable()
                    ->sortable()
                    ->label(__('zeus-bolt::forms.options.tabs.advanced.start_date'))
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('end_date')
                    ->dateTime()
                    ->searchable()
                    ->sortable()
                    ->label(__('zeus-bolt::forms.options.tabs.advanced.end_date'))
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('responses_exists')
                    ->boolean()
                    ->exists('responses')
                    ->label(__('zeus-bolt::forms.responses_exists'))
                    ->sortable()
                    ->toggleable()
                    ->searchable(false),
                TextColumn::make('responses_count')
                    ->counts('responses')
                    ->label(__('zeus-bolt::forms.responses_count'))
                    ->sortable()
                    ->toggleable()
                    ->searchable(false),
            ])
            ->recordActions(static::getActions())
            ->filters([
                TrashedFilter::make(),
                Filter::make('is_active')
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->where('is_active', true))
                    ->label(__('zeus-bolt::forms.options.tabs.display.is_active')),

                Filter::make('not_active')
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->where('is_active', false))
                    ->label(__('zeus-bolt::forms.options.tabs.display.inactive')),

                SelectFilter::make('category_id')
                    ->options(BoltPlugin::getModel('Category')::pluck('name', 'id'))
                    ->label(__('zeus-bolt::forms.options.tabs.title.category.label')),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
                ForceDeleteBulkAction::make(),
                RestoreBulkAction::make(),
            ]);
    }

    /** @phpstan-return Builder<ZeusForm> */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getPages(): array
    {
        $pages = [
            'index' => ListForms::route('/'),
            'create' => CreateForm::route('/create'),
            'edit' => EditForm::route('/{record}/edit'),
            'view' => ViewForm::route('/{record}'),
            'report' => ManageResponses::route('/{record}/report'),
            'browse' => BrowseResponses::route('/{record}/browse'),
            'viewResponse' => ViewResponse::route('/{record}/response/{responseID}'),
        ];

        if (Bolt::hasPro()) {
            // @phpstan-ignore-next-line
            $pages['prefilled'] = PrefilledForm::route('/{record}/prefilled');
            // @phpstan-ignore-next-line
            $pages['share'] = ShareForm::route('/{record}/share');
        }

        return $pages;
    }

    public static function getWidgets(): array
    {
        $widgets = [
            FormOverview::class,
            ResponsesPerMonth::class,
            ResponsesPerStatus::class,
            ResponsesPerFields::class,
        ];

        if (Bolt::hasPro()) {
            // @phpstan-ignore-next-line
            $widgets[] = ResponsesPerCollection::class;
        }

        return $widgets;
    }

    public static function getActions(): array
    {
        $action = [
            ViewAction::make(),
            EditAction::make('edit'),
            ReplicateFormAction::make(),
            RestoreAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),

            ActionGroup::make([
                Action::make('entries')
                    ->color('warning')
                    ->label(__('zeus-bolt::forms.entries'))
                    ->icon('tabler-folders')
                    ->tooltip(__('zeus-bolt::forms.view_all_entries'))
                    ->url(fn (ZeusForm $record): string => FormResource::getUrl('report', ['record' => $record])),
            ])
                ->dropdown(false),
        ];

        $advancedActions = $moreActions = [];

        if (Bolt::hasPro()) {
            $advancedActions[] = Action::make('prefilledLink')
                ->label(__('zeus-bolt::forms.actions.prefilled_link'))
                ->icon('tabler-input-spark')
                ->tooltip(__('zeus-bolt::forms.actions.prefilled_link_tooltip'))
                ->visible(Bolt::hasPro())
                ->url(fn (ZeusForm $record): string => FormResource::getUrl('prefilled', ['record' => $record]));
        }

        if (class_exists(HelenServiceProvider::class)) {
            // @phpstan-ignore-next-line
            $advancedActions[] = ShortUrlAction::make('get-link')
                ->label(__('zeus-bolt::forms.actions.short_link'))
                ->distUrl(fn (ZeusForm $record) => route(
                    BoltPlugin::get()->getRouteNamePrefix() . 'bolt.form.show',
                    $record
                ));
        }

        $moreActions[] = ActionGroup::make($advancedActions)->dropdown(false);

        return [ActionGroup::make(array_merge($action, $moreActions))];
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        $formNavs = [
            ViewForm::class,
            EditForm::class,
        ];

        if (Bolt::hasPro()) {
            // @phpstan-ignore-next-line
            $formNavs[] = ShareForm::class;
        }

        $respNavs = [
            ManageResponses::class,
            BrowseResponses::class,
        ];

        return $page->generateNavigationItems([
            ...$formNavs,
            ...$respNavs,
        ]);
    }
}
