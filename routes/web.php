<?php

use Illuminate\Support\Facades\Route;
use LaraZeus\Bolt\Http\Livewire\FillForms;
use LaraZeus\Bolt\Http\Livewire\ListEntries;
use LaraZeus\Bolt\Http\Livewire\Submitted;

Route::prefix(config('zeus-bolt.path'))->name('bolt.')->middleware('web')->group(function () {
    Route::name('user.')->middleware(config('zeus-bolt.middleware'))->group(function () {
        Route::view('/', 'zeus-bolt::forms.list-forms')->name('forms.list');
        Route::get('submitted/{slug}', Submitted::class)->name('submitted');
        Route::get('entries', ListEntries::class)->name('entries.list');
        Route::get('{slug}/{itemSlug?}', FillForms::class)->name('form.show');
    });
});
