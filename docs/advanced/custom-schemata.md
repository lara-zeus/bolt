---
title: Custom Schemata
weight: 6
---

## Add Custom Schema for fields

Bolt allows you to add custom components (additional metadata) to the form, sections, and fields.

### First: create the class

Create a class wherever you want in your app for example in `App\Zeus\CustomSchema` with the content:

```php
<?php

namespace App\Zeus\CustomSchema;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use LaraZeus\Accordion\Forms\Accordion;
use LaraZeus\Bolt\Contracts\CustomSchema;
use LaraZeus\Bolt\Fields\FieldsContract;

class Field implements CustomSchema
{
    public function make(?FieldsContract $field = null): Accordion
    {
        return Accordion::make('meta-data')
            ->schema([
                TextInput::make('options.meta.data_binding')
                    ->label('Data Binding'),
            ]);
    }

    public function hidden(?FieldsContract $field = null): array
    {
        return [
            Hidden::make('options.meta.data_binding'),
        ];
    }
}
```

- Make sure to return the hidden fields the same as the fields you have defined in the `make` method
- Make sure to set the `state` correctly, if you want to store this info in the `options` then use `options. more data, or in a separate column then make sure to create the migration for it

### Second: add it to your panel config

```php
BoltPlugin::make()
    ->customSchema([
        'form' => null,
        'section' => null,
        'field' => \App\Zeus\CustomSchema\Field::class,
    ])
```

### Third: catch it on the `FormSent` event, for example

```php
$event->response->fieldsResponses->each(function($fieldResponse){
    CustomeModel::create([
        'column' => $fieldResponse->field->options['meta']['data_binding']
    ]);
});
```

>**Warning: This is a simplified example, so don't trust your user input explicitly. That could open some pretty serious security holes.**

## Replace the Schemata with Custom one

The trait `Schemata` is the heart of the form builder, and now you can customize it to your liking.

> **Note**\
> This is an advanced feature; please use it only when necessary since you have to mainline it manually with every update for Bolt.

### First, copy the trait to your app

Copy the trait from `\LaraZeus\Bolt\Concerns` to your app, lets say: `\App\Zeus\Bolt\Concerns`

### Call the trait in a service provider

In your register method of your `AppServiceProvider` add the following:

```php
\LaraZeus\Bolt\Livewire\FillForms::getBoltFormDesignerUsing(\App\Zeus\Bolt\Concerns\Designer::class);
```

You're done. Customize the form builder to fit your needs. Remember to keep an eye on any changes in future updates so that you avoid breaking changes.