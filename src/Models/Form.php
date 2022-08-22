<?php

namespace LaraZeus\Bolt\Models;

use Database\Factories\FormFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Form extends Model
{
    use SoftDeletes;
    use HasFactory;
    use HasUpdates;
    use HasActive;

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
        return $this->belongsTo(Category::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function fields()
    {
        return $this->hasManyThrough(Field::class, Section::class);
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }

    public function fieldsResponses()
    {
        return $this->hasMany(FieldResponse::class);
    }
}
