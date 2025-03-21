<?php

namespace LaraZeus\Bolt\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use LaraZeus\Bolt\Database\Factories\FieldResponseFactory;

/**
 * @property string $response
 * @property string $updated_at
 * @property int $field_id
 * @property int $form_id
 * @property int $grade
 * @property Field $field
 */
class FieldResponse extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $with = ['field'];

    protected $guarded = [];

    public function getTable()
    {
        return config('zeus-bolt.table-prefix') . 'field_responses';
    }

    protected static function newFactory(): Factory
    {
        return FieldResponseFactory::new();
    }

    public function field(): BelongsTo
    {
        return $this->belongsTo(config('zeus-bolt.models.Field'));
    }

    public function parentResponse(): BelongsTo
    {
        return $this->belongsTo(config('zeus-bolt.models.Response'), 'response_id', 'id');
    }

    public function form(): BelongsTo
    {
        return $this->belongsTo(config('zeus-bolt.models.Form'));
    }
}
