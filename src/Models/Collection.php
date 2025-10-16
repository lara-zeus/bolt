<?php

namespace LaraZeus\Bolt\Models;

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
    use HasUpdates;
    use SoftDeletes;
    use HasTranslations;

    protected $guarded = [];

    public $translatable = ['name', 'values'];

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

    /**
     * Returns the values as a collection. Translatable variables are always cast as an array. This function transforms
     * it to a collection.
     * Note: The newer Attribute approach does not seem to be compatible with laravel-translatable ;-(.
     * @param $value
     * @return \Illuminate\Support\Collection
     */
    public function getValuesAttribute($value)
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
