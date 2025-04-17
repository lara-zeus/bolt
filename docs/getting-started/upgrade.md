---
title: Upgrading
weight: 90
---

## upgrade to v3.0.25

In v3.0.25, I added a new trait for getting the user name

So you have to add this to your User model:

`use \LaraZeus\Bolt\Models\Concerns\BelongToBolt;`

## upgrade to v2.1

In v2.1, I refactored the configuration to separate the frontend configuration from filament-related ones.
This causes an issue when having multiple panels.

1. First, publish the config file by running the command:

```bash
php artisan vendor:publish --tag="zeus-bolt-config" --force
```

2. Move your configuration from your panel provider to the `zeus-bolt` config file.

So these are the deprecated configuration methods:


```php

->boltPrefix()
->boltMiddleware()
->defaultMailable()
->uploadDisk()
->uploadDirectory()
->domain()

```

## upgrade from 2 to 3

To upgrade @zeus Bolt to v2 please check this `Core` [upgrade guide](/docs/core/v3/upgrade) 
