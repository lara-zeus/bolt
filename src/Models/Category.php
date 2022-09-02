<?php

namespace LaraZeus\Bolt\Models;

use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasFactory;
    use HasUpdates;
    use HasTranslations;

    public $translatable = ['name', 'desc'];

    protected $guarded = [];

    protected static function newFactory()
    {
        return CategoryFactory::new();
    }

    public function forms()
    {
        return $this->hasMany(Form::class);
    }
}
