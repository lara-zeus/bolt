---
title: Custom Designer
weight: 7
---

## Use Custom Designer

The class `Designer` is the one responsible for presenting the form in the frontend, and now you can customize it to your liking.

> **Note**\
> This is an advanced feature; please use it only when necessary since you have to mainline it manually with every update for Bolt.

### First, copy the class to your app

Copy the class from `\LaraZeus\Bolt\Facades` to your app, lets say: `\App\Zeus\Bolt\Classes`

### Call the class in a service provider

In your register method of your `AppServiceProvider` add the following:

```php
\LaraZeus\Bolt\Livewire\FillForms::getBoltFormDesignerUsing(\App\Zeus\Bolt\Facades\Designer::class);
```

You're done. Customize the form builder to fit your needs. Remember to keep an eye on any changes in future updates so that you avoid breaking changes.
