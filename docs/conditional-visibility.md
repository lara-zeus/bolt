
---
title: Conditional Visibility
weight: 10
---

## Conditional Visibility

You can build your form with Conditional fields and show a field based on a specific option from another field.
check out [this form](https://demo.larazeus.com/bolt/feedback) for example.

## Known limitation
- currently, you can only set the conditional field for fields with a data source (select, checkboxes ... etc.) and the toggle field. Since it's easier to validate against them,allowing all the field types will run into a complicated UI to manage different scenarios, for example, with dates (before or after), integers (higher or lower), and text... I don't even want to think about it :).
- you can select the conditional field after saving the form. otherwise, Bolt can't find the newly created fields.
- still testing them; let me know if you find any issues.