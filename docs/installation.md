---
title: Installation
weight: 3
---

## Composer

You can install the package via composer:

```bash
composer require lara-zeus/bolt
```

## Migrations
to publish the migrations files

```bash
php artisan vendor:publish --tag=zeus-bolt-migrations
```

optionally, if you want to seed the database, publish the seeder and factories with:

```bash
php artisan vendor:publish --tag=zeus-bolt-seeder
php artisan vendor:publish --tag=zeus-bolt-factories
```

## Assets
to publish the assets files for the frontend:

```bash
php artisan vendor:publish --tag=zeus-assets
```

## Run Migration
finally, run the migration:

```bash
php artisan migrate
```

## Usage

visit the url `/admin` , and `/bolt` to access the forms.
