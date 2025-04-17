---
title: Render hooks
weight: 2
---

## Render Hooks

Filament provides an elegant way to allow you to customize the UI without having to publish any views by using the `renderHook.`

Bolt also utilizes these hooks to make it easier to customize any views.

### available hooks

- `Zeus-forms.before`
  - will be rendered on the `bolt/` page before listing all categories and forms

- `Zeus-forms.after`
  - will be rendered on the `bolt/` page after listing all categories and forms

- `Zeus-form.before`
  - will be rendered above all forms before any other content like the `details.`

- `Zeus-form.after`
  - this hook will be rendered after all forms

- `Zeus-form-section.before`
  - before rendering any section in all forms

- `Zeus-form-section.after`
  - after rendering any section in all forms

- `Zeus-form-field.before`
  - before rendering any field in all forms

- `Zeus-form-field.after`
  - after rendering any field in all forms


### Usage

You can define your hooks in your service provider:

```php
Filament::registerRenderHook(
    'Zeus-form.before',
    fn (): View => view('filament.hooks.zeus.form-before'),
);
```
