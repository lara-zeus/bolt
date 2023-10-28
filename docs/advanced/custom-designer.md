---
title: Custom Designer
weight: 7
---

## Use Custom Designer

the trait `Designer` is the one responsible for presenting the form in the frontend, and now you can customize it to your liking.

> **Note**\
> This is an advanced feature; please use it only when necessary since you have to mainline it manually with every update for Bolt.

### First, copy the trait to your app:

copy the trait from `\LaraZeus\Bolt\Concerns` to your app, let say: `\App\Zeus\Bolt\Concerns`

### call the trait in a service provider

in your register method of your `AppServiceProvider` add the following:

```php
\LaraZeus\Bolt\Filament\Resources\FormResource::getBoltFormSchemaUsing(fn(): array => \App\Zeus\Bolt\Concerns\Designer::getMainFormSchema());
```

You're done. Customize the form builder to fit your needs. Remember to keep an eye on any changes in future updates so that you will avoid breaking changes.
