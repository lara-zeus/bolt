<?php

namespace LaraZeus\Bolt\Filament\Actions;

use Closure;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use LaraZeus\Bolt\BoltPlugin;
use LaraZeus\Bolt\Models\Response;

/**
 * @property Response $record
 */
class SetResponseStatus extends Action
{
    protected ?Closure $mutateRecordDataUsing = null;

    public static function getDefaultName(): ?string
    {
        return 'set-status';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->visible(function (Response $record): bool {
            return $record->form->extensions === null;
        });

        $this->label(__('zeus-bolt::forms.actions.set_status'));

        $this->icon('heroicon-o-tag');

        $this->action(function (array $data): void {
            $this->record->status = $data['status'];
            $this->record->notes = $data['notes'];
            $this->record->save();
        });

        $this->schema([
            Select::make('status')
                ->label(__('zeus-bolt::forms.status'))
                ->default(fn (Response $record) => $record->status)
                ->options(BoltPlugin::getEnum('FormsStatus'))
                ->required(),
            Textarea::make('notes')
                ->default(fn (Response $record) => $record->notes)
                ->label(__('zeus-bolt::forms.notes')),
        ]);
    }

    public function mutateRecordDataUsing(?Closure $callback): static
    {
        $this->mutateRecordDataUsing = $callback;

        return $this;
    }
}
