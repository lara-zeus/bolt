<?php

namespace LaraZeus\Bolt\Concerns;

trait HasAllowedFields
{
    /** @var array<class-string>|null */
    protected ?array $allowedFields = null;

    /** @var class-string|null */
    protected ?string $defaultField = null;

    /** @param  array<class-string>  $fields */
    public function allowedFields(array $fields): static
    {
        $this->allowedFields = $fields;

        return $this;
    }

    /** @return array<class-string>|null */
    public function getAllowedFields(): ?array
    {
        return $this->allowedFields;
    }

    /** @param  class-string  $field */
    public function defaultField(string $field): static
    {
        $this->defaultField = $field;

        return $this;
    }

    /** @return class-string|null */
    public function getDefaultField(): ?string
    {
        return $this->defaultField;
    }
}
