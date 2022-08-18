---
title: Installation
weight: 2
---

## Composer

You can install the package via composer:

```bash
composer require lara-zeus/sky
```

## Migrations
to publish the migrations files

```bash
php artisan vendor:publish --tag=zeus-sky-migrations
php artisan vendor:publish --provider="Spatie\Tags\TagsServiceProvider" --tag="tags-migrations"
php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="migrations"
```

optionally, if you want to seed the database, publish the seeder and factories with:

## Seeder and Factories
```bash
php artisan vendor:publish --tag=zeus-sky-seeder
php artisan vendor:publish --tag=zeus-sky-factories
```

## Assets
to publish the assets files for the frontend:

```bash
php artisan vendor:publish --tag=zeus-assets
php artisan vendor:publish --tag="filament-forms-tinyeditor-assets"
```

## Run Migration
finally, run the migration:

```bash
php artisan migrate
```
