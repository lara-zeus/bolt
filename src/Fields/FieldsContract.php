<?php

namespace LaraZeus\Bolt\Fields;

use Filament\Forms\Get;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use LaraZeus\Bolt\BoltPlugin;
use LaraZeus\Bolt\Concerns\HasOptions;
use LaraZeus\Bolt\Contracts\Fields;
use LaraZeus\Bolt\DataSources\DataSourceContract;
use LaraZeus\Bolt\Facades\Bolt;
use LaraZeus\Bolt\Models\Field;
use function PHPUnit\Framework\isJson;

abstract class FieldsContract implements Fields, Arrayable
{
    use HasOptions;

    public bool $disabled = false;

    public string $renderClass;

    public int $sort;

    public function toArray(): array
    {
        return [
            'disabled' => $this->disabled,
            'class' => '\\'.get_called_class(),
            'renderClass' => $this->renderClass,
            'hasOptions' => $this->hasOptions(),
            'code' => class_basename($this),
            'sort' => $this->sort,
            'title' => $this->title(),
        ];
    }

    public function title(): string
    {
        return __(class_basename($this));
    }

    public function hasOptions(): bool
    {
        return method_exists(get_called_class(), 'getOptions');
    }

    public function getResponse($field, $resp): string
    {
        return $resp->response;
    }

    public function appendFilamentComponentsOptions($component, $zeusField)
    {
        $component
            ->label($zeusField->name)
            ->id($zeusField->options['htmlId'] ?? str()->random(6))
            ->helperText($zeusField->description);

        if (isset($zeusField->options['prefix']) && $zeusField->options['prefix'] !== null) {
            $component = $component->prefix($zeusField->options['prefix']);
        }

        if (isset($zeusField->options['suffix']) && $zeusField->options['suffix'] !== null) {
            $component = $component->suffix($zeusField->options['suffix']);
        }

        if (isset($zeusField->options['is_required']) && $zeusField->options['is_required']) {
            $component = $component->required();
        }

        if (request()->filled($zeusField->options['htmlId'])) {
            $component = $component->default(request($zeusField->options['htmlId']));
        }

        $component = $component
            ->visible(function ($record, Get $get) use ($zeusField) {
                if (!isset($zeusField->options['visibility']) || !$zeusField->options['visibility']['active']) {
                    return true;
                }

                $relatedFields = $zeusField->options['visibility']['fieldID'];
                $relatedFieldsValues = $zeusField->options['visibility']['values'];

                if (empty($relatedFields) || empty($relatedFieldsValues)) {
                    return true;
                }

                $getRelatedField = $record->fields()
                    ->where('fields.id', $relatedFields)
                    ->first();

                if ($getRelatedField === null) {
                    return true;
                }

                if ($getRelatedField->type === '\LaraZeus\Bolt\Fields\Classes\Toggle') {
                    $collection = ['true', 'false'];
                } else {
                    $collection = DataSourceContract::getFieldCollectionItemsList($getRelatedField)
                        ->where('itemKey', $relatedFieldsValues)
                        ->pluck('itemKey')
                        ->toArray();
                }

                return in_array($get('zeusData.'.$relatedFields), $collection);
            });

        return $component->live(onBlur: true);
    }

    public function getCollectionsValuesForResponse($field, $resp): string
    {
        $response = $resp->response;

        if (blank($response)) {
            return '';
        }

        if (Bolt::jsJson($response)) {
            $response = json_decode($response);
            if (!is_array($response)) {
                $response = [$response];
            }
        } else {
            $response = [$response];
        }

        // to not braking old dataSource structure
        if ((int) $field->options['dataSource'] !== 0) {
            $response = BoltPlugin::getModel('Collection')::query()
                ->find($field->options['dataSource'])
                ->values->whereIn('itemKey', $response)->pluck('itemValue')->join(', ');
        } else {
            $dataSourceClass = new $field->options['dataSource'];
            $response = $dataSourceClass->getModel()::query()
                ->whereIn($dataSourceClass->getKeysUsing(), $response)
                ->pluck($dataSourceClass->getValuesUsing())
                ->join(', ');
        }

        return (is_array($response)) ? implode(', ', $response) : $response;
    }

    public static function getFieldCollectionItemsList(Field $zeusField): Collection
    {
        // to not braking old dataSource structure
        if ((int) $zeusField->options['dataSource'] === 0) {
            $dataSourceClass = new $zeusField->options['dataSource'];
            $getCollection = $dataSourceClass->getModel()::pluck(
                $dataSourceClass->getValuesUsing(),
                $dataSourceClass->getKeysUsing()
            );
        } else {
            $getCollection = BoltPlugin::getModel('Collection')::query()
                ->find($zeusField->options['dataSource'] ?? 0)
                ->values
                ->pluck('itemValue', 'itemKey');
        }

        if ($getCollection === null) {
            return collect();
        }

        return $getCollection;
    }
}
