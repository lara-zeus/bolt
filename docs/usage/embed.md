---
title: Embed the Form
weight: 3
---

## Embed the Form

@zeus Bolt forms are simply a livewire component, you can embed it in any page in your frontend or filament pages.

To embed the Form in any blade page, simply use:

```blade
<livewire:bolt.fill-form slug="feedback" inline="true" />
```

If you have an extension linked to your form, you can pass in the `extensionSlug`

```blade
<livewire:bolt.fill-form slug="feedback" extensionSlug="printers-department" inline="true" />
```

and [this](https://demo.larazeus.com/embed) is how the form looks in an empty page.

## Embed in the Sky

If you are using our package @zeus [Sky](https://larazeus.com/sky), you can embed the forms by using the code:
```html
<bolt>formSlug</bolt>
```

## Sharing on the Web
With Bolt Pro, and for your users convenience, we added a new tab in the form to make it easy to copy the code.

Read more about it in [Bolt Pro share-form](../bolt-pro/share-form)
