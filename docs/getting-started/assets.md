---
title: Themes and Assets
weight: 6
---

## Compiling assets

We use [tailwind Css](https://tailwindcss.com/) and custom themes by filament, make sure you are familiar with [tailwindcss configuration](https://tailwindcss.com/docs/configuration), and how to make a custom [filament theme](https://filamentphp.com/docs/2.x/admin/appearance#building-themes).

### Custom Classes

You need to add these files to your `tailwind.config.js` file in the `content` section.

* frontend:

```js
content: [
    //...
  './vendor/lara-zeus/core/resources/views/**/*.blade.php',
  './vendor/lara-zeus/bolt/resources/views/themes/**/*.blade.php',
]
```

* filament:

```js
content: [
    //...
  './vendor/lara-zeus/bolt/resources/views/filament/**/*.blade.php',
  './vendor/lara-zeus/accordion/resources/views/**/*.blade.php',
]
```

### Customizing the Frontend Views

First, publish the config file:

```php
php artisan vendor:publish --tag=zeus-config
```

Then change the default layout in the file `zeus.php`:

```php
'layout' => 'components.layouts.app',
// this is assuming your layout on the folder `resources/views/components/layouts/app`
```
This will give you full control for the assets files and the header and the footer.


If needed, you can publish the blade views for all zeus packages:

```php
php artisan vendor:publish --tag=zeus-views
```
