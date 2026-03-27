<?php

use LaraZeus\Bolt\BoltPlugin;
use LaraZeus\Bolt\Concerns\Schema\Fields;
use LaraZeus\Bolt\Facades\Bolt;
use LaraZeus\Bolt\Fields\Classes\Select;
use LaraZeus\Bolt\Fields\Classes\TextInput;
use LaraZeus\Bolt\Fields\Classes\Toggle;

it('returns all fields when no allowed fields are set', function () {
    $plugin = BoltPlugin::get();

    expect($plugin->getAllowedFields())->toBeNull();

    $filtered = Fields::getFilteredAvailableFields();
    $all = Bolt::availableFields();

    expect($filtered)->toHaveCount($all->count());
});

it('filters fields based on allowed fields', function () {
    BoltPlugin::get()->allowedFields([
        TextInput::class,
        Select::class,
    ]);

    $filtered = Fields::getFilteredAvailableFields();

    expect($filtered)->toHaveCount(2)
        ->and($filtered->pluck('class')->toArray())->each(
            fn ($class) => $class->toBeIn([
                '\\' . TextInput::class,
                '\\' . Select::class,
            ])
        );
});

it('defaults to first allowed field when allowed fields are set', function () {
    BoltPlugin::get()
        ->allowedFields([
            Toggle::class,
            Select::class,
        ]);

    $default = Fields::getDefaultFieldType();
    $filtered = Fields::getFilteredAvailableFields();

    expect($default)->toBe($filtered->first()['class']);
});

it('uses explicit default field when set', function () {
    BoltPlugin::get()
        ->allowedFields([
            TextInput::class,
            Select::class,
        ])
        ->defaultField(Select::class);

    $default = Fields::getDefaultFieldType();

    expect($default)->toBe('\\' . Select::class);
});

it('defaults to TextInput when no configuration is set', function () {
    $default = Fields::getDefaultFieldType();

    expect($default)->toBe('\\' . TextInput::class);
});

it('resolves label for a field not in allowed list via getOptionLabelUsing', function () {
    BoltPlugin::get()->allowedFields([
        TextInput::class,
    ]);

    $filtered = Fields::getFilteredAvailableFields();

    expect($filtered)->toHaveCount(1);

    $toggleField = Bolt::availableFields()->firstWhere('class', '\\' . Toggle::class);

    expect($toggleField)->not->toBeNull()
        ->and($toggleField['title'])->not->toBeEmpty();
});

it('throws exception when allowedFields receives an invalid class', function () {
    BoltPlugin::get()->allowedFields([
        'App\\Models\\User',
    ]);
})->throws(InvalidArgumentException::class);

it('throws exception when defaultField receives an invalid class', function () {
    BoltPlugin::get()->defaultField('App\\Models\\User');
})->throws(InvalidArgumentException::class);

afterEach(function () {
    BoltPlugin::get()->allowedFields([]);
    $reflection = new ReflectionProperty(BoltPlugin::get(), 'allowedFields');
    $reflection->setValue(BoltPlugin::get(), null);

    $reflection = new ReflectionProperty(BoltPlugin::get(), 'defaultField');
    $reflection->setValue(BoltPlugin::get(), null);
});
