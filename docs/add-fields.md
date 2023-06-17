---
title: add custom fields
weight: 6
---

## Create Custom Fields

you can add any custom fields you want that available on the [filament core](https://filamentphp.com/docs/2.x/forms/fields) or [filament plugins](https://filamentphp.com/plugins).

for example, we want to allow our users to use rating in the forms:
first install the package:

```bash
composer require yepsua/filament-rating-field
```

create the field using the following command, passing the Fully qualified names of the form component:

```bash
php artisan make:zeus-field \\Yepsua\\Filament\\Forms\\Components\\Rating
```

## Caching

bolt will automatically add the field to the form builder.
there is a cache for ll fields, so remember to flush the key `bolt.fields`

## Customization
check out the contract `LaraZeus\Bolt\Fields\FieldsContract` and see all the available methods.

available customizations:

### Disabling

you can disable any field temporally by adding:
```php
public bool $disabled = true;
```

### Field title:

```php
public function title(): string
{
    return __(class_basename($this));
}
```

### fields options
you can add any options to be shown in the admin page when creating the form

```php
public static function getOptions(): array
{
    return [
        Toggle::make('options.is_required')->label(__('Is Required')),
    ];
}
```

and to apply these options to the field:
```php
public function appendFilamentComponentsOptions($component, $zeusField)
{
    parent::appendFilamentComponentsOptions($component, $zeusField);

    if (isset($zeusField->options['is_required']) && $zeusField->options['is_required']) {
        $component = $component->required();
    }
}
```

### disable options tab
if your field doesn't have any options you can disable the options tab by removing the method `getOptions`, or return false:
```php
public function hasOptions(): bool
{
    return false;
}
```

### view the response
you can control how to present the response in the entries pages

```php
public function getResponse($field, $resp): string
{
    return $resp->response;
}
```