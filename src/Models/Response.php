<?php

namespace LaraZeus\Bolt\Models;

use Database\Factories\ResponseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $updated_at
 * @property int $form_id
 * @property string $status
 */
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
        return $this->hasMany(config('zeus-bolt.models.FieldResponse'));
    }

    public function user()
    {
        return $this->belongsTo(config('auth.providers.users.model'));
    }

    public function form()
    {
        return $this->belongsTo(config('zeus-bolt.models.Form'));
    }
}
