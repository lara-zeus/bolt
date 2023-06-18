---
title: Events
weight: 5
---

## Available Events

Bolt will fire these events:
- `LaraZeus\Bolt\Events\FormMounted`
- `LaraZeus\Bolt\Events\FormSent`

## Register a Listener:
* First, create your listener:
```bash
php artisan make:listener SendNotification --event=FormMounted
```

* Second, register the listener in your `EventServiceProvider`

```php
protected $listen = [
    //...
    LetterSent::class => [
        SendNotification::class,
    ],
];
```

* Finally, you can receive the form object in the `handle` method and do whatever you want.
  For example:

```php
Mail::to(User::first())->send(new \App\Mail\Contact(
    $event->form->name, $event->letter->email, $event->letter->message
));
```
