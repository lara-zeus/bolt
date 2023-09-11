<?php

namespace LaraZeus\Bolt;

use Closure;

trait Configuration
{
    /**
     * set the default path for the forms homepage.
     */
    protected Closure | string $boltPrefix = 'bolt';

    /**
     * the middleware you want to apply on all the forms routes
     */
    protected array $boltMiddleware = ['web'];

    /**
     * you can overwrite any model and use your own
     */
    protected array $boltModels = [
        'Category' => \LaraZeus\Bolt\Models\Category::class,
        'Collection' => \LaraZeus\Bolt\Models\Collection::class,
        'Field' => \LaraZeus\Bolt\Models\Field::class,
        'FieldResponse' => \LaraZeus\Bolt\Models\FieldResponse::class,
        'Form' => \LaraZeus\Bolt\Models\Form::class,
        'FormsStatus' => \LaraZeus\Bolt\Models\FormsStatus::class,
        'Response' => \LaraZeus\Bolt\Models\Response::class,
        'Section' => \LaraZeus\Bolt\Models\Section::class,
    ];

    /**
     * default mailable for new entries
     */
    protected string $defaultMailable = \LaraZeus\Bolt\Mail\FormSubmission::class;

    /**
     * available extensions, leave it null to disable the extensions tab from the forms
     */
    protected ?array $extensions = null;

    /**
     * where to upload all files when using the file upload field
     */
    protected Closure | string $uploadDisk = 'public';

    /**
     * the directory name
     */
    protected Closure | string $uploadDirectory = 'forms';

    /**
     * the resources navigation group
     */
    protected Closure | string $navigationGroupLabel = 'Bolt';

    public function boltPrefix(Closure | string $prefix): static
    {
        $this->boltPrefix = $prefix;

        return $this;
    }

    public function getBoltPrefix(): Closure | string
    {
        return $this->evaluate($this->boltPrefix);
    }

    public function boltMiddleware(array $middleware): static
    {
        $this->boltMiddleware = $middleware;

        return $this;
    }

    public function getMiddleware(): array
    {
        return $this->boltMiddleware;
    }

    public function boltModels(array $models): static
    {
        $this->boltModels = $models;

        return $this;
    }

    public function getBoltModels(): array
    {
        return $this->boltModels;
    }

    public static function getModel(string $model): string
    {
        return array_merge(
            (new static())->boltModels,
            (new static())::get()->getBoltModels()
        )[$model];
    }

    public function uploadDisk(Closure | string $disk): static
    {
        $this->uploadDisk = $disk;

        return $this;
    }

    public function getUploadDisk(): Closure | string
    {
        return $this->evaluate($this->uploadDisk);
    }

    public function uploadDirectory(Closure | string $dir): static
    {
        $this->uploadDirectory = $dir;

        return $this;
    }

    public function getUploadDirectory(): Closure | string
    {
        return $this->evaluate($this->uploadDirectory);
    }

    public function navigationGroupLabel(Closure | string $label): static
    {
        $this->navigationGroupLabel = $label;

        return $this;
    }

    public function getNavigationGroupLabel(): Closure | string
    {
        return $this->evaluate($this->navigationGroupLabel);
    }

    public function defaultMailable(string $mailable): static
    {
        $this->defaultMailable = $mailable;

        return $this;
    }

    public function getDefaultMailable(): string
    {
        return $this->defaultMailable;
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
