<?php

namespace LaraZeus\Bolt\Tests\Models;

use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\Factory;
use LaraZeus\Bolt\Database\Factories\UserFactory;

/**
 * @property string $email
 * @property string $name
 * @property string $password
 */
class User extends Authenticatable implements FilamentUser
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    protected $table = 'users';

    public function canAccessFilament(): bool
    {
        return true;
    }

    protected static function newFactory(): Factory
    {
        return UserFactory::new();
    }
}
