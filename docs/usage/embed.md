---
title: Embed the Form
weight: 3
---

## Embed the Form

@zeus Bolt forms are simply a livewire component, you can embed it in any page.in your frontend or filament pages.

to embed the Form in any blade page, simply use:

```blade
<livewire:bolt.fill-form slug="feedback" inline="true" />
```

and [this](https://demo.larazeus.com/embed) is how the form look in an empty page.

## Embed in the Sky

if you are using our package @zeus [Sky](https://larazeus.com/sky), you can embed the forms by using the code:
```html
<bolt>formSlug</bolt>
```

And for your user's convenience, we added a new tab in the form to make it easy to copy the code.
