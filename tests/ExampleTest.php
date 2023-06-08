<?php

use LaraZeus\Bolt\Filament\Resources\FormResource;
use LaraZeus\Bolt\Tests\Models\User;
use function Pest\Laravel\{actingAs};
use function Pest\Laravel\{get};

it('can test', function () {
    expect(true)->toBeTrue();
});

/*it('can render FormResource', function () {
    actingAs(User::create(['email' => 'admin@domain.com', 'name' => 'Admin']))
        ->get(FormResource::getUrl('index'))
        ->assertSuccessful();
});*/