<?php

namespace LaraZeus\Bolt;

use Closure;
use LaraZeus\Bolt\Enums\Resources;

trait Configuration
{
    /**
     * @deprecated deprecated since version 2.1
     * set the default path for the forms homepage.
     */
    protected Closure | string $boltPrefix = 'bolt';

    /**
     * @deprecated deprecated since version 2.1
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

    protected array $hideResources = [];

    /**
     * @deprecated deprecated since version 2.1
     * default mailable for new entries
     */
    protected string $defaultMailable = \LaraZeus\Bolt\Mail\FormSubmission::class;

    /**
     * available extensions, leave it null to disable the extensions tab from the forms
     */
    protected ?array $extensions = null;

    /**
     * where to upload all files when using the file upload field
     *
     * @deprecated deprecated since version 2.1
     */
    protected Closure | string $uploadDisk = 'public';

    /**
     * the directory name
     *
     * @deprecated deprecated since version 2.1
     */
    protected Closure | string $uploadDirectory = 'forms';

    /**
     * the resources navigation group
     */
    protected Closure | string $navigationGroupLabel = 'Bolt';

    /*
     * @deprecated deprecated since version 2.1
     */
    protected Closure | string | null $domain = null;

    protected Closure | bool $showNavigationBadges = true;

    protected array $showNavigationBadgesArray = [];

    /*
     * @deprecated deprecated since version 2.1
     */
    public function boltPrefix(Closure | string $prefix): static
    {
        $this->boltPrefix = $prefix;

        return $this;
    }

    /*
     * @deprecated deprecated since version 2.1
     */
    public function getBoltPrefix(): Closure | string
    {
        return $this->evaluate($this->boltPrefix);
    }

    /*
     * @deprecated deprecated since version 2.1
     */
    public function boltMiddleware(array $middleware): static
    {
        $this->boltMiddleware = $middleware;

        return $this;
    }

    /*
     * @deprecated deprecated since version 2.1
     */
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
            config('zeus-bolt.models'),
            (new static())::get()->getBoltModels()
        )[$model];
    }

    /*
     * @deprecated deprecated since version 2.1
     */
    public function uploadDisk(Closure | string $disk): static
    {
        $this->uploadDisk = $disk;

        return $this;
    }

    /*
     * @deprecated deprecated since version 2.1
     */
    public function getUploadDisk(): Closure | string
    {
        return $this->evaluate($this->uploadDisk);
    }

    /*
     * @deprecated deprecated since version 2.1
     */
    public function uploadDirectory(Closure | string $dir): static
    {
        $this->uploadDirectory = $dir;

        return $this;
    }

    /*
     * @deprecated deprecated since version 2.1
     */
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

    /*
     * @deprecated deprecated since version 2.1
     */
    public function defaultMailable(string $mailable): static
    {
        $this->defaultMailable = $mailable;

        return $this;
    }

    /*
     * @deprecated deprecated since version 2.1
     */
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

    /*
     * @deprecated deprecated since version 2.1
     */
    public function domain(Closure | string | null $domain): static
    {
        $this->domain = $domain;

        return $this;
    }

    /*
     * @deprecated deprecated since version 2.1
     */
    public function getDomain(): Closure | string | null
    {
        return $this->evaluate($this->domain);
    }

    public function hideResources(array $resources): static
    {
        $this->hideResources = $resources;

        return $this;
    }

    public function getHiddenResources(): ?array
    {
        return $this->hideResources;
    }

    public function hideNavigationBadges(Closure | bool $show = false, ?Resources $resource = null): static
    {
        return $this->setShowNavigationBadges($show, $resource);
    }

    public function showNavigationBadges(Closure | bool $show = true, ?Resources $resource = null): static
    {
        return $this->setShowNavigationBadges($show, $resource);
    }

    private function setShowNavigationBadges(Closure | bool $show = true, ?Resources $resource = null): static
    {
        if ($resource !== null) {
            $this->showNavigationBadgesArray[$resource->value] = $show;
        } else {
            $this->showNavigationBadges = $show;
        }

        return $this;
    }

    public function getShowNavigationBadges(?Resources $resource = null): bool
    {
        if ($resource !== null) {
            return $this->showNavigationBadgesArray[$resource->value] ?? $this->evaluate($this->showNavigationBadges);
        }

        return $this->evaluate($this->showNavigationBadges);
    }

    public static function getNavigationBadgesVisibility(?Resources $resource = null): bool
    {
        return (new static())::get()->getShowNavigationBadges($resource);
    }
}
