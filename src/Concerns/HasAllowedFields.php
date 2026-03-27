<?php

namespace LaraZeus\Bolt\Concerns;

use InvalidArgumentException;
use LaraZeus\Bolt\Fields\FieldsContract;

trait HasAllowedFields
{
    /** @var array<class-string<FieldsContract>>|null */
    protected ?array $allowedFields = null;

    /** @var class-string<FieldsContract>|null */
    protected ?string $defaultField = null;

    /** @param  array<string>  $fields */
    public function allowedFields(array $fields): static
    {
        foreach ($fields as $field) {
            if (! is_a($field, FieldsContract::class, true)) {
                throw new InvalidArgumentException("[{$field}] must extend [" . FieldsContract::class . '].');
            }
        }

        $this->allowedFields = $fields;

        return $this;
    }

    /** @return array<class-string<FieldsContract>>|null */
    public function getAllowedFields(): ?array
    {
        return $this->allowedFields;
    }

    /** @param  string  $field */
    public function defaultField(string $field): static
    {
        if (! is_a($field, FieldsContract::class, true)) {
            throw new InvalidArgumentException("[{$field}] must extend [" . FieldsContract::class . '].');
        }

        $this->defaultField = $field;

        return $this;
    }

    /** @return class-string<FieldsContract>|null */
    public function getDefaultField(): ?string
    {
        return $this->defaultField;
    }
}
