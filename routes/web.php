<?php

use Illuminate\Support\Facades\Route;
use LaraZeus\Bolt\BoltPlugin;
use LaraZeus\Bolt\Http\Livewire\FillForms;
use LaraZeus\Bolt\Http\Livewire\ListEntries;
use LaraZeus\Bolt\Http\Livewire\ListForms;
use LaraZeus\Bolt\Http\Livewire\ShowEntry;
use LaraZeus\Bolt\Http\Livewire\Submitted;

if (app('filament')->hasPlugin('zeus-rain')) {
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
