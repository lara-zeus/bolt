<?php

namespace LaraZeus\Bolt\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use JsonException;
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

    public $translatable = ['name', 'values'];

    protected $casts = [
        'values' => 'array',
    ];

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

    public function getNameAttribute($value)
    {
        if ($this->hasTranslation('name')) {
            return $value;
        }

        return $this->getRawOriginal('name');
    }

    /**
     * @throws JsonException
     */
    public function getValuesAttribute($value)
    {
        if ($this->hasTranslation('values')) {
            return $value;
        }

        if (filled($this->getRawOriginal('values'))) {
            return json_decode($this->getRawOriginal('values'), true, 512, JSON_THROW_ON_ERROR);
        }

        return $this->getRawOriginal('values');
    }

    /**
     * @param  $value
     * @return \Illuminate\Support\Collection
     */
    /*public function getValuesAttribute($value)
    {
        if($value instanceof \Illuminate\Support\Collection){
            return $value;
        }
        if(empty($value)){
            return collect();
        }
        if(is_array($value)){
            return collect($value);
        }
        if(is_string($value)){
            return collect(json_encode($value));
        }
        return collect($value);
    }*/

    protected static function newFactory(): Factory
    {
        return CollectionFactory::new();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('zeus-bolt.models.User') ?? config('auth.providers.users.model'));
    }
}
