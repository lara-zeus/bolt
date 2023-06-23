<?php

namespace LaraZeus\Bolt\Models;

use Database\Factories\FormFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

/**
 * @property string $updated_at
 * @property int $is_active
 * @property string $desc
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property array $options
 * @property string $start_date
 * @property string $end_date
 * @property bool $date_available
 * @property bool $need_login
 * @property bool $onePerUser
 */
class Form extends Model
{
    use SoftDeletes;
    use HasFactory;
    use HasUpdates;
    use HasActive;
    use HasTranslations;

    public $translatable = ['name', 'description', 'details'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected $guarded = [];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'options' => 'array',
    ];

    protected static function newFactory()
    {
        return FormFactory::new();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model'));
    }

    /** @phpstan-return BelongsTo<Form, Category> */
    public function category(): BelongsTo
    {
        return $this->belongsTo(config('zeus-bolt.models.Category'));
    }

    /** @phpstan-return hasMany<Section> */
    public function sections(): HasMany
    {
        return $this->hasMany(config('zeus-bolt.models.Section'));
    }

    /** @phpstan-return hasManyThrough<Field> */
    public function fields(): HasManyThrough
    {
        return $this->hasManyThrough(config('zeus-bolt.models.Field'), config('zeus-bolt.models.Section'));
    }

    /** @phpstan-return hasMany<Response> */
    public function responses(): hasMany
    {
        return $this->hasMany(config('zeus-bolt.models.Response'));
    }

    /** @phpstan-return hasMany<FieldResponse> */
    public function fieldsResponses(): HasMany
    {
        return $this->hasMany(config('zeus-bolt.models.FieldResponse'));
    }

    /**
     * Check if the form dates is available.
     */
    protected function dateAvailable(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->start_date === null ||
                (
                    $this->start_date !== null
                    && $this->end_date !== null
                    && now()->between($this->start_date, $this->end_date)
                ),
        );
    }

    /**
     * Check if the form require login.
     */
    protected function needLogin(): Attribute
    {
        return Attribute::make(
            get: fn () => optional($this->options)['require-login'] && ! auth()->check(),
        );
    }

    public function onePerUser(): bool
    {
        return optional($this->options)['require-login']
            && optional($this->options)['one-entry-per-user']
            && $this->responses()->where('user_id')->exists();
    }
}
