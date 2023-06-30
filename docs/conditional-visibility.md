
---
title: Conditional Visibility
weight: 10
---

## Conditional Visibility

You can build your form with Conditional fields and show a field based on a specific option from another field.
check out [this form](https://demo.larazeus.com/bolt/feedback) for example.

## Known limitation
- currently, you can only set the conditional field for files with a data source (select, checkboxes ... etc.) since it's easier to validate against them; if we allow all the field types, it will run no complicated UI to manage different scenarios, for example with dates (before or after), and integers (higher or lower), and with text... I don't want to think about it :).
- you can select the Conditional field after saving the form. Otherwise, Bolt can't find the newly created fields.
- still testing them; let me know if you find any issues.