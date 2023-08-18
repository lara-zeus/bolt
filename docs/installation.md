---
title: Installation
weight: 3
---

before you continue, please make sure you already installed filament, and all working prefecture for you.

## Composer

You can install the package via composer:

```bash
composer require lara-zeus/bolt
```

## Migrations
Publish the migrations files

```bash
php artisan vendor:publish --tag=zeus-bolt-migrations
```

## Assets
Publish the assets files for the frontend:

```bash
php artisan vendor:publish --tag=zeus-assets
```

## Run Migration
Finally, run the migration:

```bash
php artisan migrate
```

## Filament Setup

Set up the plugin with filament you need to add it to your panel provider, The default one is `adminPanelProvider`

```php
SpatieLaravelTranslatablePlugin::make()->defaultLocales([config('app.locale')]),
BoltPlugin::make()
```

## Usage

Visit the url `/admin` , and `/bolt` to access the forms.
