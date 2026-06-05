---
title: Themes and Assets
weight: 6
---

## Compiling assets

We use [Tailwind CSS](https://tailwindcss.com/) and custom Filament themes.
If you are using Tailwind CSS v4, class scanning is configured from your CSS entry file using `@source` (instead of the old `tailwind.config.js` `content` array).

### Custom Classes

Add these source paths to your app stylesheet (for example `resources/css/app.css`):

* frontend:

```css
@import "tailwindcss";

@source "../../vendor/lara-zeus/core/resources/views/**/*.blade.php";
@source "../../vendor/lara-zeus/bolt/resources/views/themes/**/*.blade.php";
```

* filament:

```css
@import "tailwindcss";

@source "../../vendor/lara-zeus/bolt/resources/views/filament/**/*.blade.php";
@source "../../vendor/lara-zeus/accordion/resources/views/**/*.blade.php";
```

> **Note**\
> In Tailwind CSS v4, keep these `@source` rules in the CSS file(s) actually used by your Vite build.

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
