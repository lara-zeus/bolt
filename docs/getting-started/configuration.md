---
title: Configuration
weight: 5
---

## Configuration

There are two different sets of configuration, for filament, and for the frontend pages

## Filament Configuration

To configure the plugin Bolt, you can pass the configuration to the plugin in `adminPanelProvider` 

These all the available configuration, and their defaults values

> **Note**\
> All these configurations are optional

```php
BoltPlugin::make()
    // the default models, by default Bolt will read from the config file 'zeus-bolt'.
    // but if you want to customize the models per panel, you can do it here 
    ->models([
        // ...
        'Category' => \App\Models\Bolt\Category::class,
        'Collection' => \App\Models\Bolt\Collection::class,
        'Field' => \App\Models\Bolt\Field::class,
        'FieldResponse' => \App\Models\Bolt\FieldResponse::class,
        'Form' => \App\Models\Bolt\Form::class,
        'Response' => \App\Models\Bolt\Response::class,
        'Section' => \App\Models\Bolt\Section::class,
        'User' => \App\Models\Staff::class,
    ])
    
    ->enums([
        'FormsStatus' => \App\Enums\Bolt\FormsStatus::class,
    ])
    
    // make the actions floating in create and edit forms
    ->formActionsAreSticky(true)
    
    ->hideResources([
        FormResource::class
    ])

    ->globallySearchableAttributes([
        // you can return empty array to disable it
        FormResource::class => ['name']
    ])
    
    ->navigationGroupLabel('Bolt')
    
    ->hideNavigationBadges(resource: LaraZeus\Bolt\Resources::CollectionResource)
    ->showNavigationBadges(resource: LaraZeus\Bolt\Resources::CollectionResource)
    
    // if you have custom extension or using thunder
    ->extensions([
        \LaraZeus\Thunder\Extensions\Thunder::class,
    ])
,
```

## Customize Filament Resources

You can customize all Bolt resources icons and sorting by adding the following code to your `AppServiceProvider` boot method

```php
FormResource::navigationSort(100);
FormResource::navigationIcon('heroicon-o-home');
FormResource::navigationGroup('New Name');
```

### Show or Hide Badges

To show all navigation badges (default)
```
    ->showNavigationBadges()
```

To hide all navigation badges
```
    ->hideNavigationBadges()
```

This will hide only the CollectionResource navigation badge
```
    ->hideNavigationBadges(resource: LaraZeus\Bolt\Resources::CollectionResource)
```

This will show only the FormResource navigation badge
```
    ->hideNavigationBadges()
    ->showNavigationBadges(resource: LaraZeus\Bolt\Resources::CollectionResource)
```

available resources:

- CategoryResource,
- CollectionResource,
- FormResource,

## Frontend Configuration

Use the file `zeus-bolt.php`, to customize the frontend, like the prefix, domain, and middleware for each content type.

To publish the configuration:

```bash
php artisan vendor:publish --tag=zeus-bolt-config
```

### Core Fields

By default Bolt discovers all of its own fields, your own [custom fields](../advanced/add-fields), and the [Bolt Pro](../bolt-pro/introduction) fields when the package is installed:

```php
'coreFields' => null,
```

To use only some of them, list the classes you want:

```php
'coreFields' => [
    \LaraZeus\Bolt\Fields\Classes\TextInput::class,
    \LaraZeus\Bolt\Fields\Classes\Select::class,
    \LaraZeus\Bolt\Fields\Classes\Toggle::class,
],
```

The array is the complete list, and nothing else is discovered. Add the Bolt Pro fields, or your own from the `collectors.fields` path, to keep them:

```php
'coreFields' => [
    \LaraZeus\Bolt\Fields\Classes\TextInput::class,
    \LaraZeus\BoltPro\Fields\SomeProField::class,
    \App\Zeus\Fields\MyField::class,
],
```

> **Note**\
> The array sets which fields are offered, not their order. Fields are ordered by the `$sort` property on the field class, and the first one becomes the default type for new fields. A class you list is skipped if it sets `$disabled = true`.

> **Important**\
> The fields are cached, and only flushed for you on the `local` environment. Anywhere else, flush the keys before your changes show up:
```bash
php artisan cache:forget bolt.fields
php artisan cache:forget bolt.allFields
```

### Custom User Model

By default Bolt will use the default Laravel user model to get the user info:

`config('auth.providers.users.model')`

If you need to change this to use another model, add the following in your config file: `zeus-bolt.php`:

```php
'models' => [
    //...
    'User' => AnotherUserModel::class,
],
```