<?php

use Illuminate\Support\Facades\Route;
use LaraZeus\Bolt\Http\Livewire\Admin\Collections;
use LaraZeus\Bolt\Http\Livewire\Admin\CreateForms;
use LaraZeus\Bolt\Http\Livewire\Admin\Entries;

Route::prefix(config('zeus-bolt.path'))->name('bolt.')->middleware('web')->group(function () {
    Route::name('user.')->middleware(config('zeus-bolt.middleware'))->group(function () {
        Route::get('list', \LaraZeus\Bolt\Http\Livewire\User\ListForms::class)->name('list');
        Route::get('submitted/{slug}', \LaraZeus\Bolt\Http\Livewire\User\Submitted::class)->name('submitted');
        Route::get('entries', \LaraZeus\Bolt\Http\Livewire\User\ListEntries::class)->name('entries.list');
        Route::get('form/{slug}', \LaraZeus\Bolt\Http\Livewire\User\FillForms::class)->name('form.show');
    });
});

Route::prefix(config('filament.path'))->name('admin.')->group(function () {
    //Route::get('forms', Forms::class)->name('list');
    Route::get('create-form', CreateForms::class)->name('zeus.form.create');
    Route::get('edit-form/{formId}', CreateForms::class)->name('form.edit');
    Route::get('collections-zeus', Collections::class)->name('collections.create');
    Route::get('entries/{id?}', Entries::class)->name('manageEntries');
});
