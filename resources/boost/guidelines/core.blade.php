## Lara Zeus Bolt (`lara-zeus/bolt`)

Lara Zeus Bolt is a Filament v5 dynamic form builder with sections, fields, conditional visibility, collections/data sources, extensions, response management, and frontend Livewire routes.

### Key Classes & Contracts
- Plugin: `LaraZeus\Bolt\BoltPlugin` (ID: `zeus-bolt`)
- Service provider: `LaraZeus\Bolt\BoltServiceProvider` (`$name = 'zeus-bolt'`)
- Facade: `LaraZeus\Bolt\Facades\Bolt` (alias `Bolt`)
- Filament resources (`LaraZeus\Bolt\Filament\Resources\*`): `FormResource`, `CategoryResource`, `CollectionResource`
- Models (`LaraZeus\Bolt\Models\*`): `Form`, `Section`, `Field`, `Response`, `FieldResponse`, `Category`, `Collection`
- User trait: `LaraZeus\Bolt\Models\Concerns\BelongToBolt`
- Livewire components: `bolt.fill-form` (`FillForms`), `bolt.list-forms` (`ListForms`), `bolt.list-entries` (`ListEntries`), `ShowEntry`
- Extensibility: `LaraZeus\Bolt\Fields\FieldsContract`, `LaraZeus\Bolt\DataSources\DataSourceContract`, `LaraZeus\Bolt\Contracts\DataSourceEnum`, `LaraZeus\Bolt\Contracts\Extension`, `LaraZeus\Bolt\Contracts\CustomFormSchema`, `LaraZeus\Bolt\Contracts\CustomSchema`, `LaraZeus\Bolt\Contracts\HtmlSanitizer`
- Events: `LaraZeus\Bolt\Events\FormMounted`, `LaraZeus\Bolt\Events\FormSent`

### Rules & Anti-Patterns
- Register `SpatieTranslatablePlugin::make()->defaultLocales([...])` alongside `BoltPlugin::make()` in your Filament panel.
- Add `LaraZeus\Bolt\Models\Concerns\BelongToBolt` to your `User` model when customizing the user display attribute (`getBoltUserFullNameAttribute()`).
- Outside `local`, `Bolt::availableFields()` and `Bolt::availableDataSource()` cache results in `bolt.fields` and `bolt.dataSources` for 1 month; clear cache after changing `zeus-bolt.coreFields` or adding fields/data sources.
- Never allow raw unescaped HTML in custom `FieldsContract::getResponse()` implementations; escape with `e()` or sanitize via `Bolt::sanitizeHtml()`.
