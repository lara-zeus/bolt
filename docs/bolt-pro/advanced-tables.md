---
title: Integrated with Advanced Tables
weight: 6
---

The Advanced Tables (formerly Filter Sets) plugin from [Kenneth Sese](https://filamentphp.com/plugins/kenneth-sese-advanced-tables), to Supercharge your tables with powerful features like user customizable views, enhanced filter tabs, reorderable columns, convenient view management, and more. Now fully integrated to create powerful reports from your dynamic forms.

You will need a separate license for the Advanced Tables plugin to activate these features.

## Enable the Advanced Tables Plugin

After installing Advanced Tables, the the filters will be available in forms immediately but you need to enable it in the Entries Report page:

Create the file
`resources/views/vendor/zeus/filament/pages/reports/entries-pro.blade.php`
or copy it from the vendor folder
and add the content:

```html
<x-filament::page class="space-y-6">
    <x-advanced-tables::favorites-bar/>
    {{ $this->table }}
</x-filament::page>
```