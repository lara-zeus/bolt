<?php

namespace LaraZeus\Bolt\Models;

use Database\Factories\FieldResponseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $updated_at
 * @property int $field_id
 * @property int $form_id
 */
class FieldResponse extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $with = ['field'];

    protected $fillable = ['form_id', 'field_id', 'response_id', 'response'];

    protected static function newFactory(): FieldResponseFactory
    {
        return FieldResponseFactory::new();
    }

    /** @return BelongsTo<Field, FieldResponse> */
    public function field(): BelongsTo
    {
        return $this->belongsTo(config('zeus-bolt.models.Field'));
    }

    /** @return BelongsTo<Response, FieldResponse> */
    public function parentResponse()
    {
        return $this->belongsTo(config('zeus-bolt.models.Response'), 'response_id', 'id');
    }

    /** @return BelongsTo<Form, FieldResponse> */
    public function form()
    {
        return $this->belongsTo(config('zeus-bolt.models.Form'));
    }
}
