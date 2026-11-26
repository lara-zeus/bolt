---
name: zeus-bolt
description: Use when installing, configuring, embedding, or extending the lara-zeus/bolt form builder in Laravel and Filament v5.
---

# Lara Zeus Bolt (`lara-zeus/bolt`)

## Overview & Requirements
`lara-zeus/bolt` is a full-featured form builder for Filament v5 and Livewire with forms, sections, conditional fields, collections, data sources, extensions, and response tracking.
- **PHP**: `^8.4`
- **Core dependencies**: `lara-zeus/core` (`^5.0`), `lara-zeus/filament-plugin-tools` (`^3.0`), `lara-zeus/accordion` (`^3.0`), `lara-zeus/list-group` (`^3.0`), `lara-zeus/tabler-icons-enum` (`^2.0`), `guava/filament-icon-picker` (`^5.0`), `flowframe/laravel-trend` (`^0.5`), `voku/anti-xss` (`^4.1`)

## Installation
```bash
composer require lara-zeus/bolt
php artisan bolt:install
```
`php artisan bolt:install` publishes `zeus-bolt-migrations`, `zeus-bolt-config`, and `zeus-assets`, and runs `php artisan migrate`.
For publishing translations/views/all assets: `php artisan bolt:publish` (`--force` supported).

Add `LaraZeus\Bolt\Models\Concerns\BelongToBolt` to your `User` model (override `getBoltUserFullNameAttribute()` if not using `name`).

## Configuration & Migrations
Published migrations (`table-prefix` defaults to `'bolt_'` in `config/zeus-bolt.php`):
`create_categories_table`, `create_collections_table`, `create_forms_table`, `create_sections_table`, `create_fields_table`, `create_responses_table`, `create_field_responses_table`, `alter_tables_constraints`.

Key options in `config/zeus-bolt.php`:
- `domain`, `prefix` (`'bolt'`), `table-prefix` (`'bolt_'`), `middleware` (`['web']`)
- `coreFields` (`null` discovers all built-in + `app/Zeus/Fields` + Bolt Pro fields; set an array of class-strings to restrict)
- `models`, `enums.FormsStatus`, `collectors.fields`, `collectors.dataSources`
- `uploadDisk` (`BOLT_FILESYSTEM_DISK`, `'public'`), `uploadDirectory` (`'forms'`), `uploadVisibility` (`'public'`), `uploadFileTypes`, `uploadMaxSize`
- `defaultMailable` (`LaraZeus\Bolt\Mail\FormSubmission::class`)
- `html_sanitizer` (`LaraZeus\Bolt\Fields\AntiXssSanitizer::class`, implements `LaraZeus\Bolt\Contracts\HtmlSanitizer`)

## Filament Panel Registration
Register both `SpatieTranslatablePlugin` and `BoltPlugin` in your PanelProvider:
```php
use LaraZeus\Bolt\BoltPlugin;
use LaraZeus\SpatieTranslatable\SpatieTranslatablePlugin;

->plugins([
    SpatieTranslatablePlugin::make()->defaultLocales([config('app.locale')]),
    BoltPlugin::make()
        ->navigationGroupLabel('Bolt')
        ->formActionsAreSticky(true),
])
```
`BoltPlugin` also supports `->models([...])`, `->enums([...])`, `->hideResources([...])`, `->globallySearchableAttributes([...])`, `->hideNavigationBadges()`, `->showNavigationBadges()`, `->customSchema(['form' => ..., 'section' => ..., 'field' => ...])`, and `->extensions([...])`.

## Core Usage
- **Frontend routes** (named `bolt.*`): `bolt.forms.list` (`/`), `bolt.entries.list` (`/entries`, `auth`), `bolt.entry.show` (`/entry/{responseID}`, `auth`), `bolt.form.show` (`/{slug}/{extensionSlug?}`).
- **Embed in Blade**:
  ```blade
  <livewire:bolt.fill-form slug="feedback" inline="true" />
  ```
- **Custom field / data source / extension**:
  - `php artisan make:zeus-field {plugin}` (creates class under `app/Zeus/Fields` extending `LaraZeus\Bolt\Fields\FieldsContract`)
  - `php artisan make:zeus-datasource {name}` (creates class under `app/Zeus/DataSources` extending `LaraZeus\Bolt\DataSources\DataSourceContract`)
  - Implement `LaraZeus\Bolt\Contracts\Extension` and pass it to `BoltPlugin::make()->extensions([...])`.
- **Events**: `LaraZeus\Bolt\Events\FormMounted`, `LaraZeus\Bolt\Events\FormSent`.

## Common Pitfalls
- **Fields not appearing after deploy**: `bolt.fields` and `bolt.dataSources` are cached for 1 month outside `local`; run `php artisan cache:forget bolt.fields` and `php artisan cache:forget bolt.dataSources`.
- **Using `coreFields` drops Pro/custom fields**: When `zeus-bolt.coreFields` is an array instead of `null`, Bolt disables auto-discovery — list every custom and Bolt Pro field class explicitly.
- **Unescaped HTML in custom fields**: Always escape user values with `e()` or sanitize HTML via `Bolt::sanitizeHtml()` in `getResponse()`.
- **Production icon performance**: Run `php artisan icons:cache` during deployment.
