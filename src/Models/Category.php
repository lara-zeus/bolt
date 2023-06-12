<?php

namespace LaraZeus\Bolt\Models;

use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Translatable\HasTranslations;

/**
 * @property string $updated_at
 * @property string $logo
 */
class Category extends Model
{
    use HasFactory;
    use HasUpdates;
    use HasTranslations;

    public $translatable = ['name', 'description'];

    protected $guarded = [];

    protected static function newFactory()
    {
        return CategoryFactory::new();
    }

    public function forms()
    {
        return $this->hasMany(config('zeus-bolt.models.Form'));
    }

    protected function logoUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => Storage::disk(config('zeus-wind.uploads.disk', 'public'))->url($this->logo),
        );
    }
}
