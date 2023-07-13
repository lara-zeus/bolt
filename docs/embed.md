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

## embed in the Sky

if you are using our package [Sky](https://larazeus.com/sky), you can embed the forms by using the code:
```html
<bolt>formSlug</bolt>
```

And for your user's convenience, we added a new tab in the form to make it easy to copy the code.

### Compiling assets
* make sure to include all the assets needed to render the form, 
* take a look at creating [custom themes](https://filamentphp.com/docs/2.x/admin/appearance#building-themes) for Filament. 
* also you must include zeus assets, the [frontend.css](https://github.com/lara-zeus/core/blob/main/resources/css/frontend.css) and [frontend.js](https://github.com/lara-zeus/core/blob/main/resources/js/filament.js)

or you can simply include the pre compiled files from zeus core:

```html
<link rel="stylesheet" href="{{ asset('vendor/zeus/frontend.css') }}">
<script src="{{ asset('vendor/zeus/app.js') }}" defer></script>
```