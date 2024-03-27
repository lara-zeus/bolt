<?php

namespace LaraZeus\Bolt;

use Closure;
use LaraZeus\Bolt\Enums\Resources;

trait Configuration
{
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
     * available extensions, leave it null to disable the extensions tab from the forms
     */
    protected ?array $extensions = null;

    /**
     * the resources navigation group
     */
    protected Closure | string $navigationGroupLabel = 'Bolt';

    protected bool $formActionsAreSticky = false;

    protected Closure | bool $showNavigationBadges = true;

    protected array $showNavigationBadgesArray = [];

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

    public function navigationGroupLabel(Closure | string $label): static
    {
        $this->navigationGroupLabel = $label;

        return $this;
    }

    public function getNavigationGroupLabel(): Closure | string
    {
        return $this->evaluate($this->navigationGroupLabel);
    }

    public function formActionsAreSticky(bool $condition = false): static
    {
        $this->formActionsAreSticky = $condition;

        return $this;
    }

    public function isFormActionsAreSticky(): bool
    {
        return $this->evaluate($this->formActionsAreSticky);
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
