---
title: Custom Fields
weight: 4
---

## Create Custom Fields

Add any custom fields you want that is available on the [filament core](https://filamentphp.com/docs/4.x/forms/overview) or [filament plugins](https://filamentphp.com/plugins).

For example, we want to allow our users to use icon picker in the forms.

### First, install the package:

```bash
composer require guava/filament-icon-picker
```

### Create bolt field

Create the field using the following command, passing the fully qualified name of the form component:

```bash
php artisan make:zeus-field \\Guava\\FilamentIconPicker\\Forms\\IconPicker
```

## Caching

Bolt will automatically list the field in the form builder.
There is a cache for all fields, so remember to flush the key `bolt.fields`

## Customization

Check out the contract `LaraZeus\Bolt\Fields\FieldsContract` and see all the available methods.

### Disabling

You can turn off any field temporally by adding:
```php
public bool $disabled = true;
```

### Field Title

```php
public function title(): string
{
    return __(class_basename($this));
}
```

### Field Options

You can add any options to be shown on the admin page when creating the form

```php
public static function getOptions(): array
{
    return [
        Toggle::make('options.is_required')->label(__('Is Required')),
    ];
}
```

And to apply these options to the field in the frontend:

```php
public function appendFilamentComponentsOptions($component, $zeusField)
{
    parent::appendFilamentComponentsOptions($component, $zeusField);

    if (isset($zeusField->options['is_required']) && $zeusField->options['is_required']) {
        $component = $component->required();
    }
}
```

### Disable the options tab

If your field doesn't have any options, you can turn off the options tab by removing the method `getOptions` or returning false:

```php
public function hasOptions(): bool
{
    return false;
}
```

### View the Response

You can control how to view the response on the entries pages

```php
public function getResponse($field, $resp): string
{
    return $resp->response;
}
```
