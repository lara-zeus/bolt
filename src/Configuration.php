<?php

namespace LaraZeus\Bolt;

trait Configuration
{
    protected array $customSchema = [
        'form' => null,
        'section' => null,
        'field' => null,
    ];

    /**
     * available extensions, leave it null to disable the extensions tab from the forms
     */
    protected ?array $extensions = null;

    public function customSchema(array $schema): static
    {
        $this->customSchema = $schema;

        return $this;
    }

    public function getCustomSchema(): array
    {
        return $this->customSchema;
    }

    public static function getSchema(string $type): ?string
    {
        return (new static)::get()->getCustomSchema()[$type];
    }

    public function extensions(?array $extensions): static
    {
        $this->extensions = $extensions;

        return $this;
    }

    public function getExtensions(): ?array
    {
        return $this->extensions;
    }
}
