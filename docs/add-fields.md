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

create a file in `Zeus\Fields\Rating.php`
the file name must be the same as the component class

```php
<?php

namespace App\Zeus\Fields;

use Filament\Forms\Components\Toggle;
use LaraZeus\Bolt\Fields\FieldsContract;

class Rating extends FieldsContract
{
    public string $renderClass = '\Yepsua\Filament\Forms\Components\Rating';

    public int $sort = 99;

    public function title(): string
    {
        return __('Rating');
    }

    public static function getOptions(): array
    {
        return [
            Toggle::make('options.is_required')->label(__('Is Required')),
        ];
    }
}

```

check out the contract `LaraZeus\Bolt\Fields\FieldsContract` and see all the available methods.


## Caching

bolt will automatically add the field to the form builder.
there is a cache for ll fields, so remember to flush the key `bolt.fields`


## Disabling

you can disable any field temporally by adding:
```php
public bool $disabled = true;
```
