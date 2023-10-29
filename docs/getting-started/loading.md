---
title: Loading indicator
weight: 7
---

## Frontend loading indicator

by default there is a loading indicator on the top left next to the breadcrumbs, but you can customize it as you want.

### the loading blade:

create the file `resources/views/vendor/zeus/themes/zeus/bolt/loading.blade.php`
the default content :

```html
<div>
    @teleport('.bolt-loading')
        <div wire:loading class="px-4">
            @svg('iconpark-loading-o', 'text-primary-600 w-8 h-8 animate-spin')
        </div>
    @endteleport
</div>
```

in your app layout add the following where you want the loader to show

```html
<div class="bolt-loading"></div>
```
