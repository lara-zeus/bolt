---
title: Configuration
weight: 5
---

## Configuration

to configure the plugin Bolt, you can pass the configuration to the plugin in `adminPanelProvider` 

these all the available configuration, and their defaults values

> **Note**\
> All these configurations are optional

```php
BoltPlugin::make()
    ->domain('forms.app.test')
    
    ->boltPrefix('')
    
    ->boltMiddleware(['web'])
    
    ->boltModels([
        'Category' => \LaraZeus\Bolt\Models\Category::class,
        'Collection' => \LaraZeus\Bolt\Models\Collection::class,
        'Field' => \LaraZeus\Bolt\Models\Field::class,
        'FieldResponse' => \LaraZeus\Bolt\Models\FieldResponse::class,
        'Form' => \LaraZeus\Bolt\Models\Form::class,
        'FormsStatus' => \LaraZeus\Bolt\Models\FormsStatus::class,
        'Response' => \LaraZeus\Bolt\Models\Response::class,
        'Section' => \LaraZeus\Bolt\Models\Section::class,
    ])
    
    ->hideResources([
        FormResource::class
    ])
    
    ->defaultMailable(
        \LaraZeus\Bolt\Mail\FormSubmission::class
    )
    
    ->extensions([
        Thunder::class,
    ])
    
    ->uploadDisk('public')
    
    ->uploadDirectory('forms')
    
    ->navigationGroupLabel('Bolt')
,
```
