<?php

namespace LaraZeus\Bolt\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use LaraZeus\Bolt\Concerns\HasUpdates;
use LaraZeus\Bolt\Database\Factories\CollectionFactory;

/**
 * @property string $updated_at
 * @property array $values
 */
class Collection extends Model
{
    use HasFactory;
    use HasUpdates;
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'values' => 'collection',
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

    protected static function newFactory(): Factory
    {
        return CollectionFactory::new();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('zeus-bolt.models.User') ?? config('auth.providers.users.model'));
    }
}
