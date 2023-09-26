---
title: Configuration
weight: 5
---

## Configuration

There is two different set of configuration, for filament, and for the frontend pages

## Filament Configuration

to configure the plugin Bolt, you can pass the configuration to the plugin in `adminPanelProvider` 

these all the available configuration, and their defaults values

> **Note**\
> All these configurations are optional

```php
BoltPlugin::make()
    // the default models, by default Bolt will read from the config file 'zeus-bolt'.
    // but if you want to customize the models per panel, you can do it here 
    ->boltModels([
        // ...
        'Category' => \LaraZeus\Bolt\Models\Category::class,
    ])
    
    ->hideResources([
        FormResource::class
    ])
    
    ->navigationGroupLabel('Bolt')
    
    ->extensions([
        Thunder::class,
    ])
,
```

## Customize Filament Resources

you can customize all Bolt resources icons and sorting by adding the following code to your `AppServiceProvider` boot method

```php
FormResource::navigationSort(100);
FormResource::navigationIcon('heroicon-o-home');
FormResource::navigationGroup('New Name');
```

available resources:

- CategoryResource,
- CollectionResource,
- FormResource,
- ResponseResource,

## Frontend Configuration

use the file `zeu-bolt.php`, to customize the frontend, like the prefix,domain, and middleware for each content type.

to publish the configuration:

```bash
php artisan vendor:publish --tag=zeus-bolt-config
```