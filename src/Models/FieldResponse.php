<?php

namespace LaraZeus\Bolt\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use LaraZeus\Bolt\BoltPlugin;
use LaraZeus\Bolt\Database\Factories\FieldResponseFactory;

/**
 * @property string $response
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
        return $this->belongsTo(BoltPlugin::getModel('Field'));
    }

    /** @return BelongsTo<Response, FieldResponse> */
    public function parentResponse()
    {
        return $this->belongsTo(BoltPlugin::getModel('Response'), 'response_id', 'id');
    }

    /** @return BelongsTo<Form, FieldResponse> */
    public function form()
    {
        return $this->belongsTo(BoltPlugin::getModel('Form'));
    }
}
