<?php

use Illuminate\Support\Facades\Route;
use LaraZeus\Bolt\BoltPlugin;
use LaraZeus\Bolt\Livewire\FillForms;
use LaraZeus\Bolt\Livewire\ListEntries;
use LaraZeus\Bolt\Livewire\ListForms;
use LaraZeus\Bolt\Livewire\ShowEntry;
use LaraZeus\Bolt\Livewire\Submitted;

if (app('filament')->hasPlugin('zeus-bolt')) {
    Route::prefix(BoltPlugin::get()->getBoltPrefix())
        ->name('bolt.')
        ->middleware(BoltPlugin::get()->getMiddleware())
        ->group(function () {
            Route::get('/', ListForms::class)
                ->name('forms.list');

            Route::get('submitted/{slug}/{extension?}', Submitted::class)
                ->name('submitted');

            Route::get('/entries', ListEntries::class)->name('entries.list')
                ->middleware('auth');

            Route::get('/entry/{responseID}', ShowEntry::class)
                ->name('entry.show')
                ->middleware('auth');

            Route::get('{slug}/{extensionSlug?}', FillForms::class)
                ->name('form.show');
        });
}
