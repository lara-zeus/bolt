<?php

use Illuminate\Support\Facades\Route;
use LaraZeus\Bolt\Http\Livewire\Admin\CreateForms;
use LaraZeus\Bolt\Http\Livewire\User\FillForms;
use LaraZeus\Bolt\Http\Livewire\User\ListEntries;
use LaraZeus\Bolt\Http\Livewire\User\ListForms;
use LaraZeus\Bolt\Http\Livewire\User\Submitted;

Route::prefix(config('zeus-bolt.path'))->name('bolt.')->middleware('web')->group(function () {
    Route::name('user.')->middleware(config('zeus-bolt.middleware'))->group(function () {
        Route::get('list', ListForms::class)->name('list');
        Route::get('submitted/{slug}', Submitted::class)->name('submitted');
        Route::get('entries', ListEntries::class)->name('entries.list');
        Route::get('form/{slug}', FillForms::class)->name('form.show');
    });
});

Route::prefix(config('filament.path'))->name('admin.')->group(function () {
    Route::get('create-form', CreateForms::class)->name('form.create');
    Route::get('edit-form/{formId}', CreateForms::class)->name('form.edit');
});
