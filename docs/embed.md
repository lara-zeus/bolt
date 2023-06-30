---
title: Embed the Form
weight: 8
---

## Embed the Form

to Embed the Form in any blade page, simply use:

```html
<livewire:bolt.fill-form slug="feedback" />
```

and [this](https://demo.larazeus.com/embed) is how the form look in an empty page.

### Compiling assets
* make sure to include all the assets needed to render the form, 
* take a look at creating [custom themes](https://filamentphp.com/docs/2.x/admin/appearance#building-themes) for Filament. 
* also you must include zeus assets, the [frontend.css](https://github.com/lara-zeus/core/blob/main/resources/css/frontend.css) and [frontend.js](https://github.com/lara-zeus/core/blob/main/resources/js/filament.js)

or you can simply include the pre compiled files from zeus core:

```html
<link rel="stylesheet" href="{{ asset('vendor/zeus/frontend.css') }}">
<script src="{{ asset('vendor/zeus/app.js') }}" defer></script>
```