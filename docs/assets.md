---
title: Thems and Assets
weight: 6
---

## Compiling assets
* make sure to include all the assets needed to render the form,
* take a look at creating [custom themes](https://filamentphp.com/docs/2.x/admin/appearance#building-themes) for Filament.

### Custom Classes:

You need to add these files to your `tailwind.config.js` file in the `content` section.

* frontend:
  * `./vendor/lara-zeus/core/resources/views/**/*.blade.php`
  * `./vendor/lara-zeus/bolt/resources/views/themes/**/*.blade.php`

* filament:
  * `./vendor/lara-zeus/bolt/resources/views/filament/**/*.blade.php`
