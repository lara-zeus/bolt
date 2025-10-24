---
title: Themes and Assets
weight: 2
---

## Compiling assets

We use [tailwind Css](https://tailwindcss.com/) and custom themes by filament, make sure you are familiar with [tailwindcss configuration](https://tailwindcss.com/docs/configuration), and how to make a custom [filament theme](https://filamentphp.com/docs/2.x/admin/appearance#building-themes).

### Custom Classes

You need to add these files to your `tailwind.config.js` file in the `content` section.

* frontend:

```js
content: [
    //...
  './vendor/lara-zeus/bolt-pro/resources/views/themes/**/*.blade.php',
]
```

* filament:

```js
content: [
    //...
  './vendor/lara-zeus/bolt-pro/resources/views/filament/**/*.blade.php',
]
```
