<?php

namespace LaraZeus\Bolt\Filament\Actions;

use Closure;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\Action;
use LaraZeus\Bolt\Models\FormsStatus;
use LaraZeus\Bolt\Models\Response;

/**
 * @property mixed $record
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

        $this->label(__('Set Status'));

        $this->icon('heroicon-o-tag');

        $this->action(function (array $data): void {
            $this->record->status = $data['status'];
            $this->record->notes = $data['notes'];
            $this->record->save();
        });

        $this->form([
            Select::make('status')
                ->label(__('status'))
                ->default(fn (Response $record) => $record->status)
                ->options(FormsStatus::query()->pluck('label', 'key'))
                ->required(),
            Textarea::make('notes')
                ->default(fn (Response $record) => $record->notes)
                ->label(__('Notes')),
        ]);

    }

    public function mutateRecordDataUsing(?Closure $callback): static
    {
        $this->mutateRecordDataUsing = $callback;

        return $this;
    }
}
