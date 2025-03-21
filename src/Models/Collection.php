<?php

namespace LaraZeus\Bolt\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use LaraZeus\Bolt\Concerns\HasUpdates;
use LaraZeus\Bolt\Database\Factories\CollectionFactory;
use Spatie\Translatable\HasTranslations;

/**
 * @property string $updated_at
 * @property array $values
 */
class Collection extends Model
{
    use HasFactory;
    use HasTranslations;
    use HasUpdates;
    use SoftDeletes;

    protected $guarded = [];

    public array $translatable = ['name', 'values'];

    public function getTable(): string
    {
        return config('zeus-bolt.table-prefix') . 'collections';
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

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => (filled($value))
                ? $value
                : $this->getRawOriginal('name'),
        );
    }

    /**
     * Returns the values as a collection. Translatable variables are always cast as an array.
     * This function transforms it to a collection.
     *
     * @throws \JsonException
     */
    protected function values(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $value = (filled($value)) ? $value : $this->getRawOriginal('values');

                if (is_string($value)) {
                    $value = collect(json_decode($value, JSON_THROW_ON_ERROR, 512, JSON_THROW_ON_ERROR));
                }

                if (is_array($value)) {
                    $value = collect($value);
                }

                return $value;
            },
        );
    }

    protected static function newFactory(): Factory
    {
        return CollectionFactory::new();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('zeus-bolt.models.User') ?? config('auth.providers.users.model'));
    }
}
