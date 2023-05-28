<?php

namespace LaraZeus\Bolt\Models;

use Database\Factories\FieldFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Field extends Model
{
    use SoftDeletes;
    use HasFactory;
    use HasTranslations;

    public $translatable = ['name'];

    protected $guarded = [];

    protected $casts = [
        'options' => 'array',
        'rules' => 'array',
    ];

    public function getAllRulesAttribute()
    {
        return collect($this->rules)->transform(function ($item) {
            return $item['rule'];
        })->join(' ');
    }

    protected static function newFactory()
    {
        return FieldFactory::new();
    }

    public function form()
    {
        return $this->belongsTo(config('zeus-bolt.models.Form'));
    }

    public function section()
    {
        return $this->belongsToMany(config('zeus-bolt.models.Section'));
    }

    public function fieldResponses()
    {
        return $this->hasOne(config('zeus-bolt.models.FieldResponse'));
    }
}
