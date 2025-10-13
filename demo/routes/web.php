<?php

use App\Models\User;
use Filament\Pages\Dashboard;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $user = User::firstOrFail();

    auth()->login($user);

    return redirect(Dashboard::getUrl());
});

Route::redirect('/admin/login', '/');
