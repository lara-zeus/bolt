---
title: Custom Schemata
weight: 7
---

the trait `Schemata` is the heart of the form builder, and now you can customize it to your liking.

> **Note**\
> This is an advanced feature; please use it only when necessary since you have to mainline it manually with every update for Bolt.

### First, copy the trait to your app:

copy the trait from `\LaraZeus\Bolt\Concerns` to your app, let say: `\App\Zeus\Bolt\Concerns`

### call the trait in a service provider

in your register method of your `AppServiceProvider` add the following:

```php
\LaraZeus\Bolt\Filament\Resources\FormResource::getBoltFormSchemaUsing(fn(): array => \App\Zeus\Bolt\Concerns\Schemata::getMainFormSchema());
```

You're done. Customize the form builder to fit your needs. Remember to keep an eye on any changes in future updates so that you will avoid breaking changes.
