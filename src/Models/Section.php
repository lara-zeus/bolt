<?php

namespace LaraZeus\Bolt\Models;

use Database\Factories\SectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $connection = 'mysql';
    protected $fillable = ['ordering'];

    protected static function newFactory()
    {
        return SectionFactory::new();
    }

    public function fields()
    {
        return $this->hasMany(Field::class, 'section_id', 'id')->orderBy('ordering');
    }
}
