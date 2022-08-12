# Changelog

All notable changes to `wind` will be documented in this file

## 1.0.3 - 2022-03-29

- add support for laravel 9
- use filament forms as the frontend
- Improve the admin and the forms

## 1.0.2 - 2022-02-10

- update assets from zeus-core

## 1.0.1 - 2022-02-10

- fix DepartmentFactory


## 1.0.0 - 2022-02-10

- refactor Categories to Departments
- change the command 'install' to 'publish'
- update readme
- update the docs

## 0.1.3 - 2022-01-19

- fix sorting in Category and Letter Resources

## 0.1.2 - 2022-01-10

- added the package `doctrine/dbal` for modifying the database

### fixes:

- set a default value if the categories are disabled
- disable category_id validation if categories are disabled

### improvements:

#### `LetterResource`:

- disable adding new Letter
- set default replay message

## 0.1.1 - 2022-01-07

small fixes and update zeus-core package.

## 0.1.0 - 2022-01-07

using [filament](https://filamentadmin.com/) as an admin panel, which give us:

- lightweight package
- fully extendable admin panel ([docs](https://filamentadmin.com/docs/2.x/admin/installation))

## 0.0.1 - 2021-12-15

- initial release
