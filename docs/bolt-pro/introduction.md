---
title: Introduction
weight: 1
---

## Zeus Bolt Pro

Advanced Forms management, More Filtering, Presets, and New Fields for Bolt the form builder

## Features

- New Fields Types
- Advanced widgets and stats
- Forms API
- Custom colors and branding per form
- Presets: create Forms with pre defined templates, or from existing forms
- Prefilled Forms URLs
- Advanced Widgets
- Sharing and embedding the form

### Get Bolt Pro from [here](https://larazeus.com/bolt-pro)

## Installation

To install bolt, you only need to require it in your composer by running the command:

```bash
composer require lara-zeus/bolt-pro
```

Make sure to clear the cache after the installation completed.

And that is all :).

You will get more details after you purchasing the package.

## Configuration

Add these configuration keys to `zeus-bolt` config file:

```php
// if you want to disable the preset button
'allow_design' => false,

// to disable the theming tab
'show_presets' => false,

// to disable the core presets
'show_core_presets' => false,

/**
 * the preview for the presets is using sushi:
 * you can enable/disable the cache here
*/
'should_cache_preset' => env('BOLT_CACHE_PRESET', true),
```
