<?php

namespace LaraZeus\Bolt;

trait Configuration
{
    //BoltPlugin::get()->getWindPrefix()

    /**
     * set the default path for the contact form homepage.
     */
    protected string $boltPrefix = 'bolt';

    /**
     * the middleware you want to apply on all the blogs routes
     * for example if you want to make your blog for users only, add the middleware 'auth'.
     */
    protected array $boltMiddleware = ['web'];

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

    protected string $uploadDisk = 'public';

    protected string $uploadDirectory = 'forms';

    protected string $navigationGroupLabel = 'Bolt';

    public function boltPrefix(string $prefix): static
    {
        $this->boltPrefix = $prefix;

        return $this;
    }

    public function getBoltPrefix(): string
    {
        return $this->boltPrefix;
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

    public function boltModels(?array $models): static
    {
        $this->boltModels = $models;

        return $this;
    }

    public function getBoltModels(): ?array
    {
        return $this->boltModels;
    }

    public static function getModel($model)
    {
        return (new static())->getBoltModels()[$model];
    }

    public function uploadDisk(string $disk): static
    {
        $this->uploadDisk = $disk;

        return $this;
    }

    public function getUploadDisk(): string
    {
        return $this->uploadDisk;
    }

    public function uploadDirectory(string $dir): static
    {
        $this->uploadDirectory = $dir;

        return $this;
    }

    public function getUploadDirectory(): string
    {
        return $this->uploadDirectory;
    }

    public function navigationGroupLabel(string $lable): static
    {
        $this->navigationGroupLabel = $lable;

        return $this;
    }

    public function getNavigationGroupLabel(): string
    {
        return $this->navigationGroupLabel;
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
