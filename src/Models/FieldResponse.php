<?php

namespace LaraZeus\Bolt\Models;

use Database\Factories\FieldResponseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FieldResponse extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $with = ['field'];

    protected $fillable = ['form_id', 'field_id', 'response_id', 'response'];

    protected static function newFactory()
    {
        return FieldResponseFactory::new();
    }

    public function field()
    {
        return $this->belongsTo(config('zeus-bolt.models.Field'));
    }

    public function parentResponse()
    {
        return $this->belongsTo(config('zeus-bolt.models.Response'), 'response_id', 'id');
    }

    public function form()
    {
        return $this->belongsTo(config('zeus-bolt.models.Form'));
    }
}
