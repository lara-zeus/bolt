<?php

namespace LaraZeus\Bolt\Models;

use Database\Factories\ResponseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use LaraZeus\Bolt\Concerns\HasUpdates;

/**
 * @property string $updated_at
 * @property int $form_id
 * @property int $user_id
 * @property string $status
 * @property string $notes
 */
class Response extends Model
{
    use SoftDeletes;
    use HasFactory;
    use HasUpdates;

    protected $with = ['form', 'user'];

    protected $fillable = ['form_id', 'status', 'notes', 'user_id'];

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
    public function form()
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
            'icon' => $getStatues->icon ?? 'heroicon-o-status-online',
            'label' => $getStatues->label ?? $this->status,
            'key' => $getStatues->key ?? '',
            'color' => $getStatues->color ?? '',
        ];
    }
}
