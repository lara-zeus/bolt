<?php

use Illuminate\Support\Facades\Route;
use LaraZeus\Bolt\Http\Livewire\Admin\Collections;
use LaraZeus\Bolt\Http\Livewire\Admin\CreateForms;
use LaraZeus\Bolt\Http\Livewire\Admin\Entries;
use LaraZeus\Bolt\Http\Livewire\Admin\Forms;

Route::prefix(config('zeus-bolt.path'))->name('bolt.')->middleware('web')->group(function () {
    Route::name('landingPage')->get('/', function () {
        return 'hi'; //view('zeus::components.landing');
    });

    Route::prefix(config('zeus-bolt.user.prefix'))->name('user.')->middleware(config('zeus-bolt.user.middleware'))->group(function () {
        Route::get('list', \LaraZeus\Bolt\Http\Livewire\User\ListForms::class)->name('list');
        Route::get('submitted/{slug}', \LaraZeus\Bolt\Http\Livewire\User\Submitted::class)->name('submitted');
        Route::get('entries', \LaraZeus\Bolt\Http\Livewire\User\ListEntries::class)->name('entries.list');
        Route::get('form/{slug}', \LaraZeus\Bolt\Http\Livewire\User\FillForms::class)->name('form.show');
    });
});

Route::get('aaaaa', CreateForms::class)->name('form.create');
Route::prefix(config('filament.path'))->name('admin.')->middleware(config('zeus-bolt.admin.middleware'))->group(function () {
    //Route::get('forms', Forms::class)->name('list');
    //Route::get('forms/edit/{formId}', CreateForms::class)->name('form.edit');
    //Route::get('collections', Collections::class)->name('collections');
    //Route::get('entries/{id?}', Entries::class)->name('manageEntries');
});
