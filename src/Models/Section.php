<?php

namespace LaraZeus\Bolt\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use LaraZeus\Bolt\BoltPlugin;
use LaraZeus\Bolt\Database\Factories\SectionFactory;
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

    protected static function booted(): void
    {
        static::deleting(function (Section $section) {
            if ($section->isForceDeleting()) {
                $section->fields()->withTrashed()->get()->each(function ($item) {
                    $item->fieldResponses()->withTrashed()->get()->each(function ($item) {
                        $item->forceDelete();
                    });
                    $item->forceDelete();
                });
            } else {
                $section->fields->each(function ($item) {
                    $item->fieldResponses->each(function ($item) {
                        $item->delete();
                    });
                    $item->delete();
                });
            }
        });
    }

    protected static function newFactory(): Factory
    {
        return SectionFactory::new();
    }

    /** @phpstan-return hasMany<Field> */
    public function fields(): HasMany
    {
        return $this->hasMany(BoltPlugin::getModel('Field'), 'section_id', 'id');
    }

    /** @return BelongsTo<Form, Section> */
    public function form(): BelongsTo
    {
        return $this->belongsTo(BoltPlugin::getModel('Form'));
    }
}
