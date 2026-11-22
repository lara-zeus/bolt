<?php

namespace LaraZeus\Bolt\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection as SupportCollection;
use LaraZeus\Bolt\Concerns\HasUpdates;
use LaraZeus\Bolt\Database\Factories\CollectionFactory;
use Spatie\Translatable\HasTranslations;
use Spatie\Translatable\Translatable;

/**
 * @property string $updated_at
 * @property string $name
 * @property SupportCollection<int, array<string, mixed>> $values
 */
class Collection extends Model
{
    use HasFactory;
    use HasTranslations {
        getAttributeValue as protected getTranslatableAttributeValue;
        getTranslation as protected getTranslatableTranslation;
        getTranslations as protected getTranslatableTranslations;
        setAttribute as protected setTranslatableAttribute;
        setTranslation as protected setTranslatableTranslation;
    }
    use HasUpdates;
    use SoftDeletes;

    public array $translatable = ['name', 'values'];

    protected $guarded = [];

    public function getTable(): string
    {
        return config('zeus-bolt.table-prefix') . 'collections';
    }

    public function getAttributeValue($key): mixed
    {
        $value = $this->getTranslatableAttributeValue($key);

        if ($key === 'values') {
            return collect(is_array($value) ? $value : []);
        }

        return $value;
    }

    public function getTranslation(string $key, string $locale, bool $useFallbackLocale = true): mixed
    {
        $translation = $this->getTranslatableTranslation($key, $locale, $useFallbackLocale);

        if ($key === 'values') {
            return is_array($translation) ? $translation : [];
        }

        return $translation;
    }

    public function getTranslations(?string $key = null, ?array $allowedLocales = null): array
    {
        if ($key === null || $this->isNestedKey($key)) {
            return $this->getTranslatableTranslations($key, $allowedLocales);
        }

        $this->guardAgainstNonTranslatableAttribute($key);

        $raw = $this->getAttributeFromArray($key);

        if (is_string($raw) && $raw !== '') {
            $decoded = json_decode($raw, true);
            $isJson = json_last_error() === JSON_ERROR_NONE;

            if ($key === 'name' && (! $isJson || ! is_array($decoded) || ($decoded !== [] && array_is_list($decoded)))) {
                return $this->filterLegacyTranslation($raw, $allowedLocales);
            }

            if ($key === 'values' && $isJson && is_array($decoded) && $decoded !== [] && array_is_list($decoded)) {
                return $this->filterLegacyTranslation($decoded, $allowedLocales);
            }
        }

        return $this->getTranslatableTranslations($key, $allowedLocales);
    }

    public function setAttribute($key, $value)
    {
        if ($key === 'values') {
            if ($value instanceof SupportCollection) {
                $value = $value->all();
            }

            if (is_array($value)) {
                if ($value === [] || array_is_list($value)) {
                    return $this->setTranslation($key, $this->getLocale(), $value);
                }

                $first = reset($value);
                if (is_array($first) && (array_key_exists('itemKey', $first) || array_key_exists('itemValue', $first))) {
                    return $this->setTranslation($key, $this->getLocale(), array_values($value));
                }

                return $this->setTranslations($key, $value);
            }
        }

        return $this->setTranslatableAttribute($key, $value);
    }

    public function setTranslation(string $key, string $locale, mixed $value): self
    {
        if ($key === 'values' && $value instanceof SupportCollection) {
            $value = $value->all();
        }

        return $this->setTranslatableTranslation($key, $locale, $value);
    }

    public function getValuesListAttribute(): ?string
    {
        $allValues = collect($this->values);

        if ($allValues->isNotEmpty()) {
            return $allValues
                ->take(5)
                ->map(function ($item) {
                    return $item['itemValue'] ?? null;
                })
                ->join(',');
        }

        return null;
    }

    protected static function newFactory(): Factory
    {
        return CollectionFactory::new();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('zeus-bolt.models.User') ?? config('auth.providers.users.model'));
    }

    /**
     * @param  array<int, string>|null  $allowedLocales
     * @return array<string, mixed>
     */
    protected function filterLegacyTranslation(mixed $legacyValue, ?array $allowedLocales = null): array
    {
        $translatableConfig = app(Translatable::class);

        return array_filter(
            [$this->resolveLegacyLocale() => $legacyValue],
            fn ($value, $locale) => $this->filterTranslations(
                $value,
                $locale,
                $allowedLocales,
                $translatableConfig->allowNullForTranslation,
                $translatableConfig->allowEmptyStringForTranslation,
            ),
            ARRAY_FILTER_USE_BOTH,
        );
    }

    protected function resolveLegacyLocale(): string
    {
        return app(Translatable::class)->fallbackLocale
            ?? config('app.fallback_locale')
            ?? config('app.locale', 'en');
    }
}
