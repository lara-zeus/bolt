---
title: Installation
weight: 2
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
