<?php

namespace LaraZeus\Bolt\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use LaraZeus\Bolt\Concerns\HasUpdates;
use LaraZeus\Bolt\Database\Factories\CategoryFactory;
use Spatie\Translatable\HasTranslations;

/**
 * @property string $updated_at
 * @property string $name
 * @property string $logo
 */
class Category extends Model
{
    use HasFactory;
    use HasTranslations;
    use HasUpdates;
    use SoftDeletes;

    public array $translatable = ['name', 'description'];

    protected $guarded = [];

    public function getTable()
    {
        return config('zeus-bolt.table-prefix') . 'categories';
    }

    protected static function newFactory(): Factory
    {
        return CategoryFactory::new();
    }

    public function forms(): HasMany
    {
        return $this->hasMany(config('zeus-bolt.models.Form'));
    }

    /**
     * @return Attribute<string, never>
     */
    protected function logoUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => Storage::disk(config('zeus-bolt.uploadDisk'))->url($this->logo),
        );
    }
}
