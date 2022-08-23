---
title: add custom fields
weight: 2
---

## Composer

for example we want to allow our users to use rating in the forms:
first install the package:
```bash
composer require yepsua/filament-rating-field
```

create a file in `Zeus\Fields\Rating.php`
the file name must be the same as the component class

```php
<?php

namespace App\Zeus\Fields;

use LaraZeus\Bolt\Fields\FieldsContract;

class Rating extends FieldsContract
{
    public $renderClass = '\Yepsua\Filament\Forms\Components\Rating';
    public $sort = 8;

    public function title()
    {
        return __('Rating');
    }

    public static function getOptions()
    {
        return [
            Toggle::make('options.is_required')->label(__('Is Required')),
        ];
    }
}
```
