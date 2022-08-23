<?php

namespace LaraZeus\Bolt\Models;

use Database\Factories\FieldFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Field extends Model
{
    use SoftDeletes;
    use HasFactory;

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

    /*public function form()
    {
        return $this->belongsTo(Form::class);
    }*/

    public function section()
    {
        return $this->belongsToMany(Section::class);
    }

    public function fieldResponses()
    {
        return $this->hasMany(FieldResponse::class);
    }
}
