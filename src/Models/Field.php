<?php

namespace LaraZeus\Bolt\Models;

use Database\Factories\FieldFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

/**
 * @property string $updated_at
 * @property string $type
 * @property int $id
 * @property array $options
 */
class Field extends Model
{
    use SoftDeletes;
    use HasFactory;
    use HasTranslations;

    public array $translatable = ['name'];

    protected $guarded = [];

    protected $casts = [
        'options' => 'array',
    ];

    protected static function newFactory(): FieldFactory
    {
        return FieldFactory::new();
    }

    /** @return BelongsTo<Form, Field> */
    public function form(): BelongsTo
    {
        return $this->belongsTo(config('zeus-bolt.models.Form'));
    }

    /** @return BelongsToMany<Section> */
    public function section(): BelongsToMany
    {
        return $this->belongsToMany(config('zeus-bolt.models.Section'));
    }

    /** @return HasOne<FieldResponse> */
    public function fieldResponses(): HasOne
    {
        return $this->hasOne(config('zeus-bolt.models.FieldResponse'));
    }
}
