<?php

namespace LaraZeus\Bolt\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use LaraZeus\Bolt\Concerns\HasUpdates;
use LaraZeus\Bolt\Database\Factories\ResponseFactory;

/**
 * @property string $updated_at
 * @property int $form_id
 * @property int $user_id
 * @property string $status
 * @property string $notes
 * @property string $response
 * @property Form $form
 */
class Response extends Model
{
    use HasFactory;
    use HasUpdates;
    use SoftDeletes;

    protected $with = ['form', 'user'];

    protected $guarded = [];

    public function getTable()
    {
        return config('zeus-bolt.table-prefix') . 'responses';
    }

    protected static function booted(): void
    {
        static::deleting(function (Response $response) {
            if ($response->isForceDeleting()) {
                $response->fieldsResponses()->withTrashed()->get()->each(function ($item) {
                    $item->forceDelete();
                });
            } else {
                $response->fieldsResponses->each(function ($item) {
                    $item->delete();
                });
            }
        });
    }

    protected static function newFactory(): ResponseFactory
    {
        return ResponseFactory::new();
    }

    /** @phpstan-return HasMany<FieldResponse> */
    public function fieldsResponses(): HasMany
    {
        return $this->hasMany(config('zeus-bolt.models.FieldResponse'));
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model'));
    }

    /** @return BelongsTo<Form, Response> */
    public function form(): BelongsTo
    {
        return $this->belongsTo(config('zeus-bolt.models.Form'));
    }

    /**
     * get status detail.
     */
    public function statusDetails(): array
    {
        $getStatues = config('zeus-bolt.models.FormsStatus')::where('key', $this->status)->first();

        return [
            'class' => $getStatues->class ?? '',
            'icon' => $getStatues->icon ?? 'heroicon-s-document',
            'label' => $getStatues->label ?? $this->status,
            'key' => $getStatues->key ?? '',
            'color' => $getStatues->color ?? '',
        ];
    }
}
