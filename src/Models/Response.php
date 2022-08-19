<?php

namespace LaraZeus\Bolt\Models;

use Database\Factories\ResponseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Response extends Model
{
    use SoftDeletes;
    use HasFactory;
    use HasUpdates;

    protected $with = ['form', 'user'];
    protected $fillable = ['form_id', 'status', 'notes', 'user_id'];

    protected static function newFactory()
    {
        return ResponseFactory::new();
    }

    public function fieldsResponses()
    {
        return $this->hasMany(FieldResponse::class);
    }

    public function user()
    {
        return $this->belongsTo(config('auth.providers.users.model'));
    }

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
