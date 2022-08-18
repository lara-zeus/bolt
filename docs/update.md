---
title: update
weight: 99
---

## Composer

to update the package first run:

```bash
composer update
```

then run the same command to publish any new files

```bash
php artisan sky:publish
```

if you want to overwrite all existing files, run:

```bash
php artisan sky:publish --force
```

=======

### updating to V2.1

if updating to V2.1, make sure to take a backup from your database,
and run the command:

```bash
php artisan sky:migrate
```

this command will migrate all the strings of the post model (title,content,description) from `string` to `json` format to support multi langs
