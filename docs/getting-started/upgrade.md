---
title: Upgrading
weight: 90
---

## Upgrade to v4

### using an enum for the status:

the namespace for the `FormsStatus` changed from `LaraZeus\\Bolt\\Models\\FormsStatus` to `LaraZeus\\Bolt\\Enums\\FormsStatus`

### Configuration:

Add to your config file:

```php
'enums' => [
    'FormsStatus' => FormsStatus::class,
],
```

and remove the key `FormsStatus` from the `models` array.

the same for the panel configuration:

```php
BoltPlugin::make()
    ->models([
        'FormsStatus' => \App\Enums\Bolt\FormsStatus::class, // [tl! --]
    ])

    ->enums([ // [tl! ++]
        'FormsStatus' => \App\Enums\Bolt\FormsStatus::class, // [tl! ++]
    ]) // [tl! ++]
```

### Is Active

we added a new option for all fields: `is_active`. its helps to "hide" a field without the need to delete it.

to migrate all your old fields options, simply run the command:

```bash
php artisan bolt:activate-fields
```

