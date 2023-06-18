# Changelog

All notable changes to `Bolt` will be documented in this file

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
