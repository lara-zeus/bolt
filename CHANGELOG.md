# Changelog

All notable changes to `Bolt` will be documented in this file

## v3.0.80 - 2025-03-18

### What's Changed

* fixes and improvements for Grade preset by @atmonshi in https://github.com/lara-zeus/bolt/pull/362

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.79...v3.0.80

## v3.0.79 - 2025-03-17

### What's Changed

* fix test by @atmonshi in https://github.com/lara-zeus/bolt/pull/356
* fix loading size by @atmonshi in https://github.com/lara-zeus/bolt/pull/361

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.78...v3.0.79

## v3.0.78 - 2025-03-07

### What's Changed

* remove iconpark by @atmonshi in https://github.com/lara-zeus/bolt/pull/355

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.77...v3.0.78

## v3.0.77 - 2025-03-07

### What's Changed

* refactor configration by @atmonshi in https://github.com/lara-zeus/bolt/pull/353
* remove clarity icons by @atmonshi in https://github.com/lara-zeus/bolt/pull/354

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.76...v3.0.77

## v3.0.76 - 2025-03-05

### What's Changed

* fix duplicated column borderless by @atmonshi in https://github.com/lara-zeus/bolt/pull/351

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.75...v3.0.76

## v3.0.75 - 2025-03-03

### What's Changed

* fix core trait by @atmonshi in https://github.com/lara-zeus/bolt/pull/350

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.74...v3.0.75

## v3.0.74 - 2025-03-03

### What's Changed

* add support for laravel 12 by @atmonshi in https://github.com/lara-zeus/bolt/pull/349

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.73...v3.0.74

## v3.0.73 - 2025-02-24

### What's Changed

* Bump dependabot/fetch-metadata from 2.2.0 to 2.3.0 by @dependabot in https://github.com/lara-zeus/bolt/pull/344
* Bump aglipanci/laravel-pint-action from 2.4 to 2.5 by @dependabot in https://github.com/lara-zeus/bolt/pull/345
* make searching case insensitive by @atmonshi in https://github.com/lara-zeus/bolt/pull/348

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.72...v3.0.73

## v3.0.72 - 2025-01-05

### What's Changed

* Update composer.lock by @atmonshi in https://github.com/lara-zeus/bolt/pull/343
* Allow sections to be styled as a Grid component instead of a Section by @holmesadam in https://github.com/lara-zeus/bolt/pull/336

### to update:

- run: `composer update`
- run: `php artisan vendor:publish --tag=zeus-bolt-migrations`, there is a [new column on section table](https://github.com/lara-zeus/bolt/blob/3.x/database/migrations/add_borderless_to_section.php.stub) `borderless`. For more info check the #336

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.71...v3.0.72

## v3.0.71 - 2024-12-24

### What's Changed

* When cloning, merge in all the options from the original item by @holmesadam in https://github.com/lara-zeus/bolt/pull/340
* Fix issue with cloning form fields by @holmesadam in https://github.com/lara-zeus/bolt/pull/338
* Fix conditional visibility when relying on a toggle field being false by @holmesadam in https://github.com/lara-zeus/bolt/pull/339
* Don't use the hint text in the tooltip by @holmesadam in https://github.com/lara-zeus/bolt/pull/342
* Allow label to be hidden on all fields by @holmesadam in https://github.com/lara-zeus/bolt/pull/341
* Fix issue with inline not working on Toggle by @holmesadam in https://github.com/lara-zeus/bolt/pull/337

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.70...v3.0.71

## v3.0.70 - 2024-12-24

### What's Changed

* Update documentation to fix typos and update consistency by @holmesadam in https://github.com/lara-zeus/bolt/pull/333
* Support for  downloading File Uploads to Private Filedisks by @aSeriousDeveloper in https://github.com/lara-zeus/bolt/pull/334

### New Contributors

* @holmesadam made their first contribution in https://github.com/lara-zeus/bolt/pull/333
* @aSeriousDeveloper made their first contribution in https://github.com/lara-zeus/bolt/pull/334

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.69...v3.0.70

## v3.0.69 - 2024-10-29

### What's Changed

* add filament tools package by @atmonshi in https://github.com/lara-zeus/bolt/pull/332

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.68...v3.0.69

## v3.0.68 - 2024-10-08

### What's Changed

* fix exported values if they're arrays by @atmonshi in https://github.com/lara-zeus/bolt/pull/330

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.67...v3.0.68

## v3.0.67 - 2024-10-02

### What's Changed

* add HasRouteNamePrefix core trait by @atmonshi in https://github.com/lara-zeus/bolt/pull/329

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.66...v3.0.67

## v3.0.66 - 2024-09-13

### What's Changed

* [Feat] : Implement caching mechanism for collection queries by @mohaphez in https://github.com/lara-zeus/bolt/pull/327

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.65...v3.0.66

## v3.0.65 - 2024-09-01

### What's Changed

* feat: custom user model by @atmonshi in https://github.com/lara-zeus/bolt/pull/324

#### Custom User Model:

By default Bolt will use this model to get the user info:

`config('auth.providers.users.model')`

if you need to change this to use another model, add the following in your config file: `zeus-bolt.php`:

```php
'models' => [
    //...
    'User' => AnotherUserModel::class,
],
















```
**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.64...v3.0.65

## v3.0.64 - 2024-08-23

### What's Changed

* add the ability conditional visibility for paragraph field by @atmonshi in https://github.com/lara-zeus/bolt/pull/322

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.63...v3.0.64

## v3.0.63 - 2024-08-16

### What's Changed

* hide visibility on create form by @atmonshi in https://github.com/lara-zeus/bolt/pull/319

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.62...v3.0.63

## v3.0.62 - 2024-07-17

### What's Changed

* fix if the field is from a preset by @atmonshi in https://github.com/lara-zeus/bolt/pull/318

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.61...v3.0.62

## v3.0.61 - 2024-07-12

### What's Changed

* Bump dependabot/fetch-metadata from 2.1.0 to 2.2.0 by @dependabot in https://github.com/lara-zeus/bolt/pull/315
* add loading indicator for the form submit button by @atmonshi in https://github.com/lara-zeus/bolt/pull/317

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.60...v3.0.61

## v3.0.60 - 2024-07-03

### What's Changed

* Added Spanish translations by @dkstudio86 in https://github.com/lara-zeus/bolt/pull/314

### New Contributors

* @dkstudio86 made their first contribution in https://github.com/lara-zeus/bolt/pull/314

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.59...v3.0.60

## v3.0.59 - 2024-06-20

### What's Changed

* [Feature] Filament Modal Form Component by @mohaphez in https://github.com/lara-zeus/bolt/pull/311

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.58...v3.0.59

## v3.0.58 - 2024-06-19

### What's Changed

* prevent delete if the form or response is linked to Extension by @atmonshi in https://github.com/lara-zeus/bolt/pull/312

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.57...v3.0.58

## v3.0.57 - 2024-06-13

### What's Changed

* up the accordion version by @atmonshi in https://github.com/lara-zeus/bolt/pull/309

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.56...v3.0.57

## v3.0.56 - 2024-06-11

### What's Changed

* set export toggle to yes no by @atmonshi in https://github.com/lara-zeus/bolt/pull/308

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.55...v3.0.56

## v3.0.55 - 2024-06-11

### What's Changed

* remove default filter date by @atmonshi in https://github.com/lara-zeus/bolt/pull/307

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.54...v3.0.55

## v3.0.54 - 2024-06-11

### What's Changed

* allow for custom entry for responses by @atmonshi in https://github.com/lara-zeus/bolt/pull/304
* fix toggle table column and use custom entry by @atmonshi in https://github.com/lara-zeus/bolt/pull/305
* add created at filter for responses  by @atmonshi in https://github.com/lara-zeus/bolt/pull/306

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.53...v3.0.54

## v3.0.53 - 2024-06-10

### What's Changed

* Custom schema by @atmonshi in https://github.com/lara-zeus/bolt/pull/301

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.52...v3.0.53

## v3.0.52 - 2024-06-09

### What's Changed

* fix clone field to set the HTML ID by @atmonshi in https://github.com/lara-zeus/bolt/pull/302

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.51...v3.0.52

## v3.0.51 - 2024-06-07

### What's Changed

* hot fix for fields options on edit by @atmonshi in https://github.com/lara-zeus/bolt/pull/299

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.50...v3.0.51

## v3.0.50 - 2024-06-06

### What's Changed

* clean up some codes by @atmonshi in https://github.com/lara-zeus/bolt/pull/298

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.49...v3.0.50

## v3.0.49 - 2024-06-06

### What's Changed

* fix return type for Factory by @atmonshi in https://github.com/lara-zeus/bolt/pull/297

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.48...v3.0.49

## v3.0.48 - 2024-06-02

### What's Changed

* fix sortable by @atmonshi in https://github.com/lara-zeus/bolt/pull/296

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.47...v3.0.48

## v3.0.47 - 2024-05-31

### What's Changed

* fix for is pro not installed by @atmonshi in https://github.com/lara-zeus/bolt/pull/295

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.46...v3.0.47

## v3.0.46 - 2024-05-30

### What's Changed

* empty boltModels by default, set the config or override them in your … by @atmonshi in https://github.com/lara-zeus/bolt/pull/293

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.45...v3.0.46

## v3.0.45 - 2024-05-30

### What's Changed

* fixes and improvements for grading and disable searchable for counts … by @atmonshi in https://github.com/lara-zeus/bolt/pull/292

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.44...v3.0.45

## v3.0.44 - 2024-05-30

### What's Changed

* Paragraph with html by @atmonshi in https://github.com/lara-zeus/bolt/pull/290

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.43...v3.0.44

## v3.0.43 - 2024-05-29

### What's Changed

* fix response action url by @atmonshi in https://github.com/lara-zeus/bolt/pull/289

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.42...v3.0.43

## v3.0.42 - 2024-05-28

### What's Changed

* improvements on how to check if pro version installed by @atmonshi in https://github.com/lara-zeus/bolt/pull/288

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.41...v3.0.42

## v3.0.41 - 2024-05-28

### What's Changed

* fix collection not found by @atmonshi in https://github.com/lara-zeus/bolt/pull/287

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.40...v3.0.41

## v3.0.40 - 2024-05-27

### What's Changed

* fix visibility with live select by @atmonshi in https://github.com/lara-zeus/bolt/pull/286

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.39...v3.0.40

## v3.0.39 - 2024-05-17

### What's Changed

* [Bugfix/select options] Resolve HasOptions Merge Issue and Documentation Update by @mohaphez in https://github.com/lara-zeus/bolt/pull/285

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.38...v3.0.39

## v3.0.38 - 2024-05-03

### What's Changed

* Bump dependabot/fetch-metadata from 2.0.0 to 2.1.0 by @dependabot in https://github.com/lara-zeus/bolt/pull/279
* support upload visibility by @atmonshi in https://github.com/lara-zeus/bolt/pull/280

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.37...v3.0.38

## v3.0.37 - 2024-04-21

### What's Changed

* [Feature] Add getQuery Method by @mohaphez in https://github.com/lara-zeus/bolt/pull/277

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.36...v3.0.37

## v3.0.3٦ - 2024-04-17

### What's Changed

* Bump aglipanci/laravel-pint-action from 2.3.1 to 2.4 by @dependabot in https://github.com/lara-zeus/bolt/pull/273
* [Feature] Configuration Enhancement: Enable customization of the collectors paths for fields and datasources by @mohaphez in https://github.com/lara-zeus/bolt/pull/275

### New Contributors

* @mohaphez made their first contribution in https://github.com/lara-zeus/bolt/pull/275

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.35...v3.0.3%D9%A6

## v3.0.35 - 2024-04-15

### What's Changed

* check for policies in create option for Collection and Category by @atmonshi in https://github.com/lara-zeus/bolt/pull/272

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.34...v3.0.35

## v3.0.34 - 2024-04-07

### What's Changed

* fix  datasource in checklist by @atmonshi in https://github.com/lara-zeus/bolt/pull/271
  fix datasource in checklist

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.33...v3.0.34

## v3.0.33 - 2024-04-07

### What's Changed

* Ditch type hint by @atmonshi in https://github.com/lara-zeus/bolt/pull/270

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.32...v3.0.33

## v3.0.32 - 2024-04-04

### What's Changed

* Fix category tenant by @atmonshi in https://github.com/lara-zeus/bolt/pull/269

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.31...v3.0.32

## v3.0.31 - 2024-04-02

### What's Changed

* improve toggle options adding color and inline. fix section visibility by @atmonshi in https://github.com/lara-zeus/bolt/pull/268

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.30...v3.0.31

## v3.0.30 - 2024-03-29

### What's Changed

* remove column classes in browse entries by @atmonshi in https://github.com/lara-zeus/bolt/pull/267

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.29...v3.0.30

## v3.0.29 - 2024-03-27

### What's Changed

* add sticky form actions by @atmonshi in https://github.com/lara-zeus/bolt/pull/266

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.28...v3.0.29

## v3.0.28 - 2024-03-26

### What's Changed

* Bump dependabot/fetch-metadata from 1.6.0 to 2.0.0 by @dependabot in https://github.com/lara-zeus/bolt/pull/264
* Fix section icon when shoe the form as a page by @atmonshi in https://github.com/lara-zeus/bolt/pull/265

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.27...v3.0.28

## v3.0.27 - 2024-03-14

### What's Changed

* updating laravel trend to support laravel 11 by @atmonshi in https://github.com/lara-zeus/bolt/pull/263

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.26...v3.0.27

## v3.0.26 - 2024-03-07

### What's Changed

* Bump ramsey/composer-install from 2 to 3 by @dependabot in https://github.com/lara-zeus/bolt/pull/261
* better response view for Textarea field by @atmonshi in https://github.com/lara-zeus/bolt/pull/262

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.25...v3.0.26

## v3.0.25 - 2024-03-02

### What's Changed

* adding a new trait for user attribute by @atmonshi in https://github.com/lara-zeus/bolt/pull/260

#### Breaking change:

I added a new trait for getting the user name

so you have to add this to your user model:

`use \LaraZeus\Bolt\Models\Concerns\BelongToBolt;`

This will allow you to get the user name by another attribute like `full_name`

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.24...v3.0.25

## v3.0.24 - 2024-03-01

### What's Changed

* Update fill-forms.blade.php fix for livewire by @brkfun in https://github.com/lara-zeus/bolt/pull/259

### New Contributors

* @brkfun made their first contribution in https://github.com/lara-zeus/bolt/pull/259

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.23...v3.0.24

## v3.0.23 - 2024-02-16

### What's Changed

* improve install command by @atmonshi in https://github.com/lara-zeus/bolt/pull/258

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.22...v3.0.23

## v3.0.22 - 2024-02-13

### What's Changed

* hide FileUpload Fields from the response table and improve UI for view response by @atmonshi in https://github.com/lara-zeus/bolt/pull/257

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.21...v3.0.22

## v3.0.21 - 2024-02-10

### What's Changed

* add list for all forms links connected to an ext by @atmonshi in https://github.com/lara-zeus/bolt/pull/255

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.20...v3.0.21

## v3.0.20 - 2024-02-10

### What's Changed

* adding getGloballySearchableAttributes configuration by @atmonshi in https://github.com/lara-zeus/bolt/pull/254

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.19...v3.0.20

## v3.0.19 - 2024-02-09

### What's Changed

* implementing filament export by @atmonshi in https://github.com/lara-zeus/bolt/pull/253

now you can export responses using filament export
and you can remove the fork for `alperenersoy/filament-export`

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.18...v3.0.19

## v3.0.18 - 2024-02-09

### What's Changed

* add missing translation form email by @atmonshi in https://github.com/lara-zeus/bolt/pull/252

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.17...v3.0.18

## v3.0.17 - 2024-02-07

### What's Changed

* fix slot name for sections by @atmonshi in https://github.com/lara-zeus/bolt/pull/251

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.16...v3.0.17

## v3.0.1٧ - 2024-02-07

### What's Changed

* fix slot name for sections by @atmonshi in https://github.com/lara-zeus/bolt/pull/251

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.16...v3.0.1%D9%A7

## v3.0.16 - 2024-02-06

### What's Changed

* get the default format from `Infolist::$defaultDateDisplayFormat` by @atmonshi in https://github.com/lara-zeus/bolt/pull/249
* add more translation by @atmonshi in https://github.com/lara-zeus/bolt/pull/250

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.15...v3.0.16

## v3.0.15 - 2024-02-05

### What's Changed

* Embed with extension and allow to customize the user attribute by @atmonshi in https://github.com/lara-zeus/bolt/pull/248

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.14...v3.0.15

## v3.0.14 - 2024-01-31

### What's Changed

* Change form layout to improve UX by @atmonshi in https://github.com/lara-zeus/bolt/pull/247

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.13...v3.0.14

## v3.0.13 - 2024-01-20

### What's Changed

* improve toggle in Entries Report by @atmonshi in https://github.com/lara-zeus/bolt/pull/245

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.12...v3.0.13

## v3.0.12 - 2024-01-19

### What's Changed

* add configuration to set database prefix by @atmonshi in https://github.com/lara-zeus/bolt/pull/244

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.11...v3.0.12

## v3.0.11 - 2024-01-19

### What's Changed

* add new status for thunder: open by @atmonshi in https://github.com/lara-zeus/bolt/pull/243

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.10...v3.0.11

## v3.0.10 - 2024-01-15

### What's Changed

* Field type selector with icons and descriptions by @atmonshi in https://github.com/lara-zeus/bolt/pull/242

<img width="947" alt="Screenshot 2024-01-15 at 3 09 41 AM" src="https://github.com/lara-zeus/bolt/assets/1952412/b7a6b4ed-d9a2-4374-a5dc-847b46fce493">
**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.9...v3.0.10
## v3.0.9 - 2024-01-13
### What's Changed
* remove deprecated configuration methods by @atmonshi in https://github.com/lara-zeus/bolt/pull/241
**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.8...v3.0.9
## v3.0.8 - 2024-01-13
### What's Changed
* add confirmation before running the migration by @atmonshi in https://github.com/lara-zeus/bolt/pull/240
**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.7...v3.0.8
## v3.0.7 - 2024-01-13
### What's Changed
* Add configuration options for navigation badges by @Edsardio in https://github.com/lara-zeus/bolt/pull/237
* small refactor on Navigation Badges Visibility by @atmonshi in https://github.com/lara-zeus/bolt/pull/238
* update docs by @atmonshi in https://github.com/lara-zeus/bolt/pull/239
### New Contributors
* @Edsardio made their first contribution in https://github.com/lara-zeus/bolt/pull/237
**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.6...v3.0.7
## v3.0.6 - 2024-01-12
### What's Changed
* add Share Form for Bolt Pro by @atmonshi in https://github.com/lara-zeus/bolt/pull/236
**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.5...v3.0.6
## v3.0.5 - 2024-01-11
### What's Changed
* add form ID column in form table but hidden by default by @atmonshi in https://github.com/lara-zeus/bolt/pull/235
**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.4...v3.0.5
## v3.0.4 - 2024-01-10
**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v2.1.32...v3.0.4
## v2.1.32 - 2024-01-10
### What's Changed
* fix pre-filled link for tenant by @atmonshi in https://github.com/lara-zeus/bolt/pull/233
**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.3...v2.1.32
## v3.0.3 - 2024-01-10
### What's Changed
* improve Conditional Visibility by @atmonshi in https://github.com/lara-zeus/bolt/pull/232
**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v3.0.2...v3.0.3
## v2.1.30 - 2024-01-08
### What's Changed
* Bump aglipanci/laravel-pint-action from 2.3.0 to 2.3.1 by @dependabot in https://github.com/lara-zeus/bolt/pull/221
* fix badge count for multi tenant by @atmonshi in https://github.com/lara-zeus/bolt/pull/226
**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v2.1.29...v2.1.30
## v2.1.29 - 2023-12-14
### What's Changed
* update docs by @atmonshi in https://github.com/lara-zeus/bolt/pull/219
**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v2.1.28...v2.1.29
## v2.1.28 - 2023-12-14
### What's Changed
* Update doc and css by @atmonshi in https://github.com/lara-zeus/bolt/pull/218
**Full Changelog**: https://github.com/lara-zeus/bolt/compare/v2.1.27...v2.1.28
## 1.2.12 - 2023-08-14
### What's Changed
- change reactive to debounce by @atmonshi in https://github.com/lara-zeus/bolt/pull/119
**Full Changelog**: https://github.com/lara-zeus/bolt/compare/1.2.11...1.2.12
## 1.2.11 - 2023-08-06
### What's Changed
- add german translation by @grafst in https://github.com/lara-zeus/bolt/pull/107
### New Contributors
- @grafst made their first contribution in https://github.com/lara-zeus/bolt/pull/107
**Full Changelog**: https://github.com/lara-zeus/bolt/compare/1.2.10...1.2.11
## 1.2.10 - 2023-07-13
### What's Changed
- allow to toggle Conditional Visibility by a toggle field by @atmonshi in https://github.com/lara-zeus/bolt/pull/101
- fix sections ID when display the form as a wizard by @atmonshi in https://github.com/lara-zeus/bolt/pull/102
- Embed by @atmonshi in https://github.com/lara-zeus/bolt/pull/103
**Full Changelog**: https://github.com/lara-zeus/bolt/compare/1.2.9...1.2.10
## 1.2.9 - 2023-07-12
### What's Changed
- fix sorting in collections by @atmonshi in https://github.com/lara-zeus/bolt/pull/97
- fix date ended and add some validation by @atmonshi in https://github.com/lara-zeus/bolt/pull/98
- update core by @atmonshi in https://github.com/lara-zeus/bolt/pull/99
**Full Changelog**: https://github.com/lara-zeus/bolt/compare/1.2.8...1.2.9
## 1.2.8 - 2023-07-11
### What's Changed
- allow to set the default value by string param by @atmonshi in https://github.com/lara-zeus/bolt/pull/96
**Full Changelog**: https://github.com/lara-zeus/bolt/compare/1.2.7...1.2.8
## 1.2.7 - 2023-07-06
### What's Changed
- add some tests for the form resource and fill-form frontend page by @atmonshi in https://github.com/lara-zeus/bolt/pull/92
- require at least one section and field by @atmonshi in https://github.com/lara-zeus/bolt/pull/95
- add more tests by @atmonshi in https://github.com/lara-zeus/bolt/pull/94
**Full Changelog**: https://github.com/lara-zeus/bolt/compare/1.2.6...1.2.7
## 1.2.6 - 2023-07-04

### What's Changed

- Bump dependabot/fetch-metadata from 1.5.1 to 1.6.0 by @dependabot in https://github.com/lara-zeus/bolt/pull/91
- update all dependecies by @atmonshi in https://github.com/lara-zeus/bolt/pull/93

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/1.2.5...1.2.6

## 1.2.5 - 2023-07-02

### What's Changed

- add Constraints and delete relations, with support for soft delete  by @atmonshi in https://github.com/lara-zeus/bolt/pull/90

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/1.2.4...1.2.5

## 1.2.4 - 2023-07-01

### What's Changed

- add `not-prose` for forms, so the style won't suck when the form embed… by @atmonshi in https://github.com/lara-zeus/bolt/pull/89

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/1.2.3...1.2.4

## 1.2.3 - 2023-06-30

### What's Changed

- add docs on how to embed the form in any blade file by @atmonshi in https://github.com/lara-zeus/bolt/pull/86
- more docs by @atmonshi in https://github.com/lara-zeus/bolt/pull/87
- update core by @atmonshi in https://github.com/lara-zeus/bolt/pull/88

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/1.2.2...1.2.3

## 1.2.2 - 2023-06-29

### What's Changed

- fix: pass ext data instead of depending on request by @atmonshi in https://github.com/lara-zeus/bolt/pull/85

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/1.2.1...1.2.2

## 1.2.0 - 2023-06-28

### What's Changed

- Allow Conditional Visibility for fields by @atmonshi in https://github.com/lara-zeus/bolt/pull/82
- Add HasOptions to handle common fields options better
- Refactor common fields options
- Fix options and store the Conditional Visibility in field options
- Add collapsed to form sections and fields when editing forms

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/1.1.1...1.2.0

## 1.1.1 - 2023-06-27

### What's Changed

- add french by @jvkassi in https://github.com/lara-zeus/bolt/pull/73
- Add missing phrases by @atmonshi in https://github.com/lara-zeus/bolt/pull/74
- Add missing phrases to fr by @atmonshi in https://github.com/lara-zeus/bolt/pull/78
- store the extension item id in response by @atmonshi in https://github.com/lara-zeus/bolt/pull/77
- refactor set status action and hide it if the form has extension by @atmonshi in https://github.com/lara-zeus/bolt/pull/76
- fix if the extensions not exist in edit forms by @atmonshi in https://github.com/lara-zeus/bolt/pull/75
- clean up show response blades and improve get status details by @atmonshi in https://github.com/lara-zeus/bolt/pull/79
- add missing keys to status by @atmonshi in https://github.com/lara-zeus/bolt/pull/81
- add extension label by @atmonshi in https://github.com/lara-zeus/bolt/pull/80

### New Contributors

- @jvkassi made their first contribution in https://github.com/lara-zeus/bolt/pull/73

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/1.1.0...1.1.1

## 1.1.0 - 2023-06-24

### What's Changed

- Add Extensions by @atmonshi in https://github.com/lara-zeus/bolt/pull/71

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/1.0.2...1.1.0

## 1.0.2 - 2023-06-23

### What's Changed

- fix require_login by @atmonshi in https://github.com/lara-zeus/bolt/pull/72

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/1.0.1...1.0.2

## 1.0.1 - 2023-06-19

### What's Changed

- fix primary color 🦩 by @atmonshi in https://github.com/lara-zeus/bolt/pull/70

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/1.0.0...1.0.1

## 1.0.0 - 2023-06-18

### What's Changed

- finally out of demo 🤞 by @atmonshi in https://github.com/lara-zeus/bolt/pull/69

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/0.0.47...1.0.0

## 0.0.43 - 2023-06-16

### What's Changed

- update composer by @atmonshi in https://github.com/lara-zeus/bolt/pull/62

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/0.0.42...0.0.43

## 0.0.40 - 2023-06-13

### What's Changed

- add Filters and searches by @atmonshi in https://github.com/lara-zeus/bolt/pull/59

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/0.0.39...0.0.40

## 0.0.39 - 2023-06-12

### What's Changed

- add exporting entries action by @atmonshi in https://github.com/lara-zeus/bolt/pull/57
- using `alperenersoy/filament-export`
- 
- add Replicate Action for forms with its sections and fields by @atmonshi in https://github.com/lara-zeus/bolt/pull/58
- 

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/0.0.38...0.0.39

## 0.0.38 - 2023-06-12

### What's Changed

- finalizing the entries report and cleaning up the navigations between different views
- update docs
- allow setting entry notes
- add action set the status to browse and repost

#### Entries per each form now have three views:

- list: list the response only as cards
- browse: how the response with the fields one per page
- report: table view for all entries and their fields

#### 🔴🔴 Database refactor:

In preparation for the first release, I made some changes and refactored the database structure for constancy.
no migration, you can create your own or simply apply it from the database directly, remember this is still a beta version :).

##### table `fields` drop these columns

- html_id
- html_name
- rules
- layout_position

##### table `forms` rename the column `desc` to `description`

##### table `forms` drop `layout` column

##### table `sections` rename these fields:

- section_column
- section_descriptions
- section_icon
- section_aside

to

- columns
- description
- icon
- aside

##### table `categories` rename `desc` to `description`

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/0.0.37...0.0.38

## 0.0.37 - 2023-06-11

### What's Changed

- fix default data type for TextInput by @atmonshi in https://github.com/lara-zeus/bolt/pull/55

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/0.0.36...0.0.37

## 0.0.36 - 2023-06-11

### What's Changed

- improvements and fixes in zeus fields by @atmonshi in https://github.com/lara-zeus/bolt/pull/54
- Chenge: cheange `text` Data type to `string` for TextInput
- Change: removing MultiSelect field since it's the same as Select with `multiple" option

If you're in production already, you have to change it in DB by creating a migration or editing it manually

Improve: the fields options UI.

fix: show the response for Radio Field
fix: saving values if the field is not required

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/0.0.35...0.0.36

## 0.0.35 - 2023-06-09

### What's Changed

- update docs by @atmonshi in https://github.com/lara-zeus/bolt/pull/53

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/0.0.34...0.0.35

## 0.0.34 - 2023-06-09

### What's Changed

- fix widget by @atmonshi in https://github.com/lara-zeus/bolt/pull/52

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/0.0.33...0.0.34

## 0.0.33 - 2023-06-09

### What's Changed

- refactor widget by @atmonshi in https://github.com/lara-zeus/bolt/pull/51

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/0.0.32...0.0.33

## 0.0.32 - 2023-06-09

### What's Changed

- Multi response value and more by @atmonshi in https://github.com/lara-zeus/bolt/pull/50
- 
- allow to store and display multi values as in select multiple or checkboxes
- 
- add an edit button to view the form on the admin page
- 
- add a note when editing collections
- 

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/0.0.31...0.0.32

## 0.0.31 - 2023-06-08

### What's Changed

- rename some fields placeholders and add buttons on view form page by @atmonshi in https://github.com/lara-zeus/bolt/pull/48
- add test by @atmonshi in https://github.com/lara-zeus/bolt/pull/49

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/0.0.30...0.0.31

## 0.0.30 - 2023-06-06

### What's Changed

- Actions by @atmonshi in https://github.com/lara-zeus/bolt/pull/47
- better actions and improve fields to apply default values.
- better responsive layout for fields in admin page
- fixes for phpstan

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/0.0.29...0.0.30

## 0.0.29 - 2023-06-05

### What's Changed

- add widgets
- add view form page in admin
- update readme and introduction to mark some features as done 💪
- update docs to add events

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/0.0.28...0.0.29

## 0.0.28 - 2023-06-04

### What's Changed

- updates by @atmonshi in https://github.com/lara-zeus/bolt/pull/44

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/0.0.27...0.0.28

## 0.0.27 - 2023-06-02

### What's Changed

- update zeus-core by @atmonshi in https://github.com/lara-zeus/bolt/pull/43

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/0.0.26...0.0.27

## 0.0.26 - 2023-06-02

### What's Changed

- Bump aglipanci/laravel-pint-action from 2.2.0 to 2.3.0 by @dependabot in https://github.com/lara-zeus/bolt/pull/41
- Bump dependabot/fetch-metadata from 1.4.0 to 1.5.1 by @dependabot in https://github.com/lara-zeus/bolt/pull/42

🆕 new form layout added: tabs
🆕 allow setting columns number per section
🆕 add section description
🆕 Set Section Icon available for Tabs and Wizerd
🆕 Option to view the section as aside

✨ Localized all phrases, currently supporting (English and Arabic)
✨ Improve the overall UI for viewing the responses.
✨ You can set the status for each response

❗️removed the route group `user`
⚠️ run `php artisan migrate` for the new migration: `add_fields_to_sections_table`

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/0.0.25...0.0.26

## 0.0.25 - 2023-05-28

### What's Changed

- add ar phrases by @atmonshi in https://github.com/lara-zeus/bolt/pull/40

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/0.0.24...0.0.25

## 0.0.24 - 2023-05-28

### What's Changed

- Config models by @atmonshi in https://github.com/lara-zeus/bolt/pull/39

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/0.0.23...0.0.24

## 0.0.23 - 2023-05-28

### What's Changed

🔥 Adding `Filament Plugin Purge` for better and thinner CSS file.

🚩 The component `<x-zeus::box>` is retired, and now we using `<x-filament::card>` instead.

🟢 Always add `@php artisan vendor:publish --tag=zeus-assets --ansi --force` to `post-update-cmd` in your composer file.

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/0.0.22...0.0.23

## 0.0.22 - 2023-05-28

### What's Changed

- Update core by @atmonshi in https://github.com/lara-zeus/bolt/pull/37

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/0.0.21...0.0.22

## 0.0.21 - 2023-05-20

### What's Changed

- Bump dependabot/fetch-metadata from 1.3.6 to 1.4.0 by @dependabot in https://github.com/lara-zeus/bolt/pull/35
- remove lang files for now

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/0.0.20...0.0.21

## 0.0.20 - 2023-04-10

### What's Changed

- Bump dependabot/fetch-metadata from 1.3.3 to 1.3.4 by @dependabot in https://github.com/lara-zeus/bolt/pull/28
- Bump dependabot/fetch-metadata from 1.3.4 to 1.3.5 by @dependabot in https://github.com/lara-zeus/bolt/pull/29
- Bump dependabot/fetch-metadata from 1.3.5 to 1.3.6 by @dependabot in https://github.com/lara-zeus/bolt/pull/32
- support laravel 10 by @atmonshi in https://github.com/lara-zeus/bolt/pull/34
- Bump aglipanci/laravel-pint-action from 1.0.0 to 2.2.0 by @dependabot in https://github.com/lara-zeus/bolt/pull/33
- Bump ramsey/composer-install from 1 to 2 by @dependabot in https://github.com/lara-zeus/bolt/pull/30

### New Contributors

- @dependabot made their first contribution in https://github.com/lara-zeus/bolt/pull/28

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/0.0.19...0.0.20

## 0.0.19 - 2022-09-24

### What's Changed

- Support ext by @atmonshi in https://github.com/lara-zeus/bolt/pull/26
- 
- composer core update by @atmonshi in https://github.com/lara-zeus/bolt/pull/27
- 
- add features and roadmap
- 
- add zeus render hooks
- 
- list all user entries and show entry details
- 
- small changes to the UI
- 
- refactor all fields classes
- 
- improvements in all resources
- 
- use the new table layout in forms and entries
- 
- refactor filling the form component
- 
- add form status sushi model
- 

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/0.0.18...0.0.19

## 0.0.18 - 2022-09-18

### What's Changed

- improve responsive layout by @atmonshi in https://github.com/lara-zeus/bolt/pull/25

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/0.0.17...0.0.18

## 0.0.17 - 2022-09-17

- improve skeleton and add tests and dark mode
- separate the CSS for frontend and filament
- update .github workflows
- add phpstan and pint

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/0.0.16...0.0.17

## 0.0.16 - 2022-09-16

### What's Changed

- hello Thunder ⛈ by @atmonshi in https://github.com/lara-zeus/bolt/pull/24

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/0.0.15...0.0.16

## 0.0.15 - 2022-09-14

### What's Changed

- Apply fixes from StyleCI by @atmonshi in https://github.com/lara-zeus/bolt/pull/23
- remove checkbox and only use toggle by @atmonshi in https://github.com/lara-zeus/bolt/pull/22

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/0.0.14...0.0.15

## 0.0.14 - 2022-09-11

### What's Changed

- small fixes by @atmonshi in https://github.com/lara-zeus/bolt/pull/20
- Apply fixes from StyleCI by @atmonshi in https://github.com/lara-zeus/bolt/pull/21

set upload disk and dir
set the layout from the config

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/0.0.13...0.0.14

## 0.0.13 - 2022-09-10

### What's Changed

- updates by @atmonshi in https://github.com/lara-zeus/bolt/pull/19
- 
- update core
- 
- improve the fields options using tabs
- 
- fix small bugs
- 
- enable the required option
- 

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/0.0.12...0.0.13

## 0.0.12 - 2022-09-08

### What's Changed

- add event by @atmonshi in https://github.com/lara-zeus/bolt/pull/17
- check if class exist by @atmonshi in https://github.com/lara-zeus/bolt/pull/18

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/0.0.11...0.0.12

## 0.0.11 - 2022-09-02

### What's Changed

- improve responses view by @atmonshi in https://github.com/lara-zeus/bolt/pull/16
- Please republish the database migration
- updated the default bolt seeder

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/0.0.10...0.0.11

## 0.0.10 - 2022-09-01

### What's Changed

- improvements by @atmonshi in https://github.com/lara-zeus/bolt/pull/15

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/0.0.9...0.0.10

## 0.0.9 - 2022-08-27

### What's Changed

- Settings by @atmonshi in https://github.com/lara-zeus/bolt/pull/14
- 
- form settings better UI
- 
- update migrations
- 
- delete unused files
- 

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/0.0.8...0.0.9

## 0.0.8 - 2022-08-24

### What's Changed

- update composer and assets by @atmonshi in https://github.com/lara-zeus/bolt/pull/13

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/0.0.7...0.0.8

## 0.0.7 - 2022-08-23

### What's Changed

- More fields by @atmonshi in https://github.com/lara-zeus/bolt/pull/12

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/0.0.6...0.0.7

## 0.0.6 - 2022-08-22

### What's Changed

- update db and small fixes by @atmonshi in https://github.com/lara-zeus/bolt/pull/10
- Imporve resourses by @atmonshi in https://github.com/lara-zeus/bolt/pull/11

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/0.0.5...0.0.6

## 0.0.5 - 2022-08-21

### What's Changed

- Apply fixes from StyleCI by @atmonshi in https://github.com/lara-zeus/bolt/pull/9
- convert to filament by @atmonshi in https://github.com/lara-zeus/bolt/pull/8

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/0.0.4...0.0.5

## 0.0.4 - 2022-08-20

### What's Changed

- Apply fixes from StyleCI by @atmonshi in https://github.com/lara-zeus/bolt/pull/7
- clean up and add beta note widget by @atmonshi in https://github.com/lara-zeus/bolt/pull/6

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/0.0.3...0.0.4

## 0.0.3 - 2022-08-19

### What's Changed

- fix remove section by @atmonshi in https://github.com/lara-zeus/bolt/pull/3
- fixes in fields by @atmonshi in https://github.com/lara-zeus/bolt/pull/4
- Apply fixes from StyleCI by @atmonshi in https://github.com/lara-zeus/bolt/pull/5

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/0.0.2...0.0.3

## 0.0.2 - 2022-08-19

### What's Changed

- Apply fixes from StyleCI by @atmonshi in https://github.com/lara-zeus/bolt/pull/1
- Apply fixes from CodeFactor by @atmonshi in https://github.com/lara-zeus/bolt/pull/2
- update readme
- update docs

### New Contributors

- @atmonshi made their first contribution in https://github.com/lara-zeus/bolt/pull/1

**Full Changelog**: https://github.com/lara-zeus/bolt/compare/0.0.1...0.0.2

## 0.0.1 - 2022-08-19

- initial release
