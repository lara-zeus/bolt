<?php

use LaraZeus\Bolt\Filament\Resources\CollectionResource\Pages\CreateCollection;
use LaraZeus\Bolt\Filament\Resources\CollectionResource\Pages\EditCollection;
use LaraZeus\Bolt\Models\Collection;

use function Pest\Livewire\livewire;

function firstValueRow($component): string
{
    return array_key_first($component->get('data.values'));
}

it('fills the key from the value on a new row', function () {
    $component = livewire(CreateCollection::class);
    $row = firstValueRow($component);

    $component
        ->set("data.values.{$row}.itemValue", 'Red')
        ->assertSet("data.values.{$row}.itemKey", 'Red')
        ->set("data.values.{$row}.itemValue", 'Dark Red')
        ->assertSet("data.values.{$row}.itemKey", 'Dark Red');
});

it('does not overwrite a key the user typed', function () {
    $component = livewire(CreateCollection::class);
    $row = firstValueRow($component);

    $component
        ->set("data.values.{$row}.itemValue", 'Red')
        ->set("data.values.{$row}.itemKey", 'r1')
        ->set("data.values.{$row}.itemValue", 'Dark Red')
        ->assertSet("data.values.{$row}.itemKey", 'r1');
});

it('does not overwrite a key typed before the value', function () {
    $component = livewire(CreateCollection::class);
    $row = firstValueRow($component);

    $component
        ->set("data.values.{$row}.itemKey", 'r1')
        ->set("data.values.{$row}.itemValue", 'Red')
        ->assertSet("data.values.{$row}.itemKey", 'r1');
});

it('refills the key after the user clears it', function () {
    $component = livewire(CreateCollection::class);
    $row = firstValueRow($component);

    $component
        ->set("data.values.{$row}.itemValue", 'Red')
        ->set("data.values.{$row}.itemKey", '')
        ->set("data.values.{$row}.itemValue", 'Blue')
        ->assertSet("data.values.{$row}.itemKey", 'Blue');
});

it('saves the auto-filled key', function () {
    $component = livewire(CreateCollection::class);
    $row = firstValueRow($component);

    $component
        ->set('data.name', 'Colors')
        ->set("data.values.{$row}.itemValue", 'Red')
        ->call('create')
        ->assertHasNoFormErrors();

    expect(Collection::query()->where('name', 'Colors')->first()->values->all())
        ->toBe([['itemValue' => 'Red', 'itemKey' => 'Red', 'itemIsDefault' => false]]);
});

it('never changes the key of a saved row', function () {
    $collection = Collection::create([
        'name' => 'Colors',
        'values' => [['itemValue' => 'Red', 'itemKey' => 'Red', 'itemIsDefault' => false]],
    ]);

    $component = livewire(EditCollection::class, ['record' => $collection->getRouteKey()]);
    $row = firstValueRow($component);

    $component
        ->set("data.values.{$row}.itemValue", 'Crimson')
        ->assertSet("data.values.{$row}.itemKey", 'Red');
});

it('fills an empty key on a row added to a saved collection', function () {
    $collection = Collection::create([
        'name' => 'Colors',
        'values' => [['itemValue' => 'Red', 'itemKey' => 'Red', 'itemIsDefault' => false]],
    ]);

    $component = livewire(EditCollection::class, ['record' => $collection->getRouteKey()]);
    $saved = firstValueRow($component);

    $component->call('mountAction', 'add', [], ['schemaComponent' => 'form.values'])
        ->callMountedAction();

    $row = array_key_last($component->get('data.values'));

    expect($row)->not->toBe($saved);

    $component
        ->set("data.values.{$row}.itemValue", 'Blue')
        ->assertSet("data.values.{$row}.itemKey", 'Blue')
        ->set("data.values.{$row}.itemValue", 'Navy')
        ->assertSet("data.values.{$row}.itemKey", 'Blue');
});
