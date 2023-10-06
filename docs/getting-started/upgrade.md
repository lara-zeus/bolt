---
title: Upgrading
weight: 90
---

## upgrade to v2.1

In v2.1, I refactored the configuration to separate the frontend configuration from filament-related ones.
This causes an issue when having multiple panels.

1. First, publish the config file by running the command:

```bash
php artisan vendor:publish --tag="zeus-bolt-config" --force
```

2. move your configuration from your panel provider to the `zeus-bolt` config file.

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

to upgrade @zeus Bolt to v2 please check this `Core` [upgrade guid](/docs/core/v3/upgrade) 
