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
    use SoftDeletes;
    use HasFactory;
    use HasUpdates;

    protected $fillable = ['name', 'values', 'user_id'];

    protected $casts = [
        'values' => 'collection',
    ];

    public function getValuesListAttribute(): string
    {
        $someValues = '';
        $someValuesCount = 0;
        if ($this->values !== null) {
            $allValues = collect($this->values);
            $someValuesCount = $allValues->count();
            $someValues = $allValues->take(5)
                ->map(function ($item) {
                    return $item['itemValue'] = '<span class="tager text-xs text-gray-700 font-semibold px-1.5 py-0.5 rounded-md">' . $item['itemValue'] . '</span>';
                })
                ->join(' ');
        }
        $more = ($someValuesCount > 5) ? '...' : '';

        return $someValues . $more;
    }

    protected static function newFactory(): Factory
    {
        return CollectionFactory::new();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model'));
    }
}
