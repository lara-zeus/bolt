<?php

namespace LaraZeus\Bolt\Models;

use Database\Factories\SectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

/**
 * @property string $updated_at
 * @property string $name
 * @property string $columns
 * @property string $description
 * @property string $aside
 */
class Section extends Model
{
    use SoftDeletes;
    use HasFactory;
    use HasTranslations;

    public array $translatable = ['name'];

    protected $guarded = [];

    protected static function newFactory(): SectionFactory
    {
        return SectionFactory::new();
    }

    /** @phpstan-return hasMany<Field> */
    public function fields(): HasMany
    {
        return $this->hasMany(config('zeus-bolt.models.Field'), 'section_id', 'id');
    }

    /** @return BelongsTo<Form, Section> */
    public function form(): BelongsTo
    {
        return $this->belongsTo(config('zeus-bolt.models.Form'));
    }
}
