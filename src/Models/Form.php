<?php

namespace LaraZeus\Bolt\Models;

use Database\Factories\FormFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Form extends Model
{
    use SoftDeletes;
    use HasFactory;
    use HasUpdates;
    use HasActive;
    use HasTranslations;

    public $translatable = ['name', 'desc', 'details'/*, 'options.confirmation-message'*/];

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

    public function user()
    {
        return $this->belongsTo(config('auth.providers.users.model'));
    }

    public function category()
    {
        return $this->belongsTo(config('zeus-bolt.models.Category'));
    }

    public function sections()
    {
        return $this->hasMany(config('zeus-bolt.models.Section'));
    }

    public function fields()
    {
        return $this->hasManyThrough(config('zeus-bolt.models.Field'), config('zeus-bolt.models.Section'));
    }

    public function responses()
    {
        return $this->hasMany(config('zeus-bolt.models.Response'));
    }

    public function fieldsResponses()
    {
        return $this->hasMany(config('zeus-bolt.models.FieldResponse'));
    }
}
