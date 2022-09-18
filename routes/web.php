<?php

use Illuminate\Support\Facades\Route;
use LaraZeus\Bolt\Http\Livewire\FillForms;
use LaraZeus\Bolt\Http\Livewire\ListForms;
use LaraZeus\Bolt\Http\Livewire\Submitted;

Route::prefix(config('zeus-bolt.path'))->name('bolt.')->middleware('web')->group(function () {
    Route::name('user.')->middleware(config('zeus-bolt.middleware'))->group(function () {
        Route::get('/', ListForms::class)->name('forms.list');
        Route::get('submitted/{slug}', Submitted::class)->name('submitted');
        Route::get('{slug}/{itemSlug?}', FillForms::class)->name('form.show');
    });
});
