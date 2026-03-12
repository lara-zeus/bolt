<?php

use Illuminate\Support\Facades\Cache;
use LaraZeus\Bolt\Facades\Bolt;
use LaraZeus\Bolt\Facades\Collectors;
use LaraZeus\Bolt\Fields\Classes\Select;
use LaraZeus\Bolt\Fields\Classes\TextInput;
use LaraZeus\Bolt\Fields\Classes\Toggle;
use LaraZeus\Bolt\Tests\Fields\DummyField;

beforeEach(function () {
    Cache::flush();

    $this->autoDiscoveredFields = Collectors::collectClasses(
        __DIR__ . '/../src/Fields/Classes',
        'LaraZeus\\Bolt\\Fields\\Classes\\'
    );
});

describe('allFields', function () {
    it('auto-discovers all core fields when coreFields config is null', function () {
        config()->set('zeus-bolt.coreFields', null);

        $fields = Bolt::allFields();

        expect($fields)->toHaveCount($this->autoDiscoveredFields->count())
            ->and($fields->keys()->toArray())->toBe($this->autoDiscoveredFields->sortBy('sort')->keys()->toArray());
    });

    it('merges configured coreFields alongside auto-discovered fields', function () {
        config()->set('zeus-bolt.coreFields', [
            DummyField::class,
        ]);

        $fields = Bolt::allFields();

        expect($fields)->toHaveCount($this->autoDiscoveredFields->count() + 1)
            ->and($fields->keys()->toArray())->toContain('DummyField');
    });

    it('does not duplicate when configured coreFields overlap with auto-discovered', function () {
        config()->set('zeus-bolt.coreFields', [
            TextInput::class,
        ]);

        $fields = Bolt::allFields();

        expect($fields)->toHaveCount($this->autoDiscoveredFields->count());
    });
});

describe('availableFields', function () {
    it('auto-discovers all core fields when coreFields config is null', function () {
        config()->set('zeus-bolt.coreFields', null);

        $fields = Bolt::availableFields();

        expect($fields)->toHaveCount($this->autoDiscoveredFields->count())
            ->and($fields->keys()->toArray())->toBe($this->autoDiscoveredFields->sortBy('sort')->keys()->toArray());
    });

    it('returns only configured fields when coreFields is an array', function () {
        config()->set('zeus-bolt.coreFields', [
            TextInput::class,
            Select::class,
        ]);

        $fields = Bolt::availableFields();

        expect($fields)->toHaveCount(2)
            ->and($fields->keys()->toArray())->toBe(['TextInput', 'Select']);
    });

    it('returns a single configured field', function () {
        config()->set('zeus-bolt.coreFields', [
            Toggle::class,
        ]);

        $fields = Bolt::availableFields();

        expect($fields)->toHaveCount(1)
            ->and($fields->keys()->first())->toBe('Toggle');
    });

    it('returns empty collection when coreFields is an empty array', function () {
        config()->set('zeus-bolt.coreFields', []);

        $fields = Bolt::availableFields();

        expect($fields)->toBeEmpty();
    });

    it('includes a custom field when configured', function () {
        config()->set('zeus-bolt.coreFields', [
            TextInput::class,
            DummyField::class,
        ]);

        $fields = Bolt::availableFields();

        expect($fields)->toHaveCount(2)
            ->and($fields->keys()->toArray())->toBe(['TextInput', 'DummyField']);
    });

    it('returns fields as arrays with required keys', function () {
        config()->set('zeus-bolt.coreFields', null);

        $fields = Bolt::availableFields();

        foreach ($fields as $key => $field) {
            expect($field)->toHaveKeys([
                'disabled',
                'class',
                'renderClass',
                'hasOptions',
                'code',
                'sort',
                'title',
                'description',
                'icon',
            ], "Field '{$key}' is missing required keys");
        }
    });
});
