---
title: render hooks
weight: 7
---

## Render Hooks

filament provide an elegant way to allow you to customize the UI without having to publish any views by using the `renderHook`

Bolt also utilize these hooks to make it easier for you to customize any views

### available hooks

- `zeus-forms.before`
  - will be rendered in the `bolt/` page before listing all categorises and forms

- `zeus-forms.after`
  - will be rendered in the `bolt/` page after listing all categorises and forms

- `zeus-form.before`
  - will be rendered above all forms, before any other content like the `details`

- `zeus-form.after`
  - this hook will be rendered after all forms

- `zeus-form-section.before`
  - before rendering any section in all forms

- `zeus-form-section.after`
  - after rendering any section in all forms

- `zeus-form-field.before`
  - before rendering any field in all forms

- `zeus-form-field.after`
  - after rendering any field in all forms


### Usage

you can define your hooks in your service provider:

```php
Filament::registerRenderHook(
    'zeus-form.before',
    fn (): View => view('filament.hooks.zeus.form-before'),
);
```
