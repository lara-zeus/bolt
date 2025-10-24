---
title: Extensions
weight: 3
---

## Extensions

Bolt offer a simple way to build your own application around the forms, with a simple interface, called `extensions` :

Extensions are hooks based classes that let you perform your logic around the forms or catch the submission and do more integrations with other apps or external APIs.
for example before showing the form, or after storing the data etc...

## Available Hooks:

- `canView`
  before displaying the form, you can do some checks

- `render`
  what to show at the beginning of the form, you can return a view to show more info or instructors while filling out the form

-`formComponents`
  return an array of filament components to add them to the form in the frontend

- `store`
  the store logic for the extension, insert to any DB or external API

- `postStore`
  this is typically used for sending only. It will be executed after saving the form

- `submittedRender`
  this will show any info after saving the form, like a request number or more buttons and links


## Creating an Extension

Create a class in your app with the following content:

>I will create a command later :)

```php

<?php

namespace App\Zeus\Extensions;

use Filament\Forms\Components\TextInput;
use LaraZeus\Bolt\Contracts\Extension;
use LaraZeus\Bolt\Models\Form;

class Items implements Extension
{
    public function label(): string
    {
        return 'Ext Name';
    }

    public function canView(Form $form, array $data): bool|array|null
    {
        // abort_if ...
        // get the ext app and return it back, so you can receive it in the render
        // return [];
    }

    public function render(Form $form, array $data): string|null
    {
        // set any data and pas it to your view
        // $data['items'] = ...

        // return view();
    }

    public function formComponents(Form $form): array|null
    {
        return [
            TextInput::make('extensions.order_number'),
        ];
    }

    public function store(Form $form, array $data): array|null
    {
        /*$model = Model::create([
            'order_number' => $data['order_number'],
            // ...
        ]);*/

        // return these data to recive them after the form submitted
        // $data['model'] = $model;

        return $data;
    }

    public function postStore(Form $form, array $data): void
    {
        // send emails
        // fire some events
    }

    public function SubmittedRender(Form $form, array $data): string|null
    {
        // return view()->with('data', $data);
    }
}

```

## Enabling The Extension

In your panel provider, for example `AdminPanelProvider`, add your extension to the array:

```php
BoltPlugin::make()
  ->extensions([
      \App\Zeus\Extensions\Items::class,
  ])
```

Now when creating or editing a form, you will see the tab Extensions, and you can select any extension per form.
