---
title: Custom Datasource
weight: 5
---

## Caching

Bolt will automatically list the data sources from your app in the form builder as a collection.
There is a cache for all collections, so remember to flush the key `bolt.datasources`

## From Database

Create a custom data source for your forms and make it available as a collection.
Datasources are helpful for creating custom collections from different models or an external API.

To create datasource, use the following command, passing the name of the datasource:

```bash
php artisan make:zeus-datasource Car
```

### Customization

Check out the contract `LaraZeus\Bolt\DataSources\DataSourceContract` and see all the available methods.

### Disabling

You can turn off any field temporally by adding:

```php
public bool $disabled = true;
```

## From Enum

Create a normal enum class and implement `LaraZeus\Bolt\Contracts\DataSourceEnum` interface, for example:

```php
use Illuminate\Contracts\Support\Htmlable;
use LaraZeus\Bolt\DataSources\DataSourceData;
use LaraZeus\Bolt\Contracts\DataSourceEnum;

enum Status: string implements DataSourceEnum
{
    case Approve = 'approve';
    case Pending = 'pending';

    public function getDataSourceLabel(): string|Htmlable|null
    {
        return match ($this) {
            self::Approve => 'approved',
            self::Pending => 'waiting'
        };
    }

    public static function toDataSourceData(): DataSourceData
    {
        return DataSourceData::make(
                title: __('status'),
                class: static::class
            )
            
             //disable a source, optional: when configuring the fields you can turn off ability to select this data source.
             ->disabled(false)
             
             //sorting, optional
             ->sort(1);
    }
}
```

### Customization

Check out the contract `LaraZeus\Bolt\DataSources\DataSourceData` and see all the available methods.
