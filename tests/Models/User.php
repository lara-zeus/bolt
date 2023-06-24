<?php

namespace LaraZeus\Bolt\Tests\Models;

use Filament\Models\Contracts\FilamentUser;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property string $email
 * @property string $name
 * @property string $password
 */
class User extends Authenticatable implements FilamentUser
{
    protected $guarded = [];

    public $timestamps = false;

    protected $table = 'users';

    public function canAccessFilament(): bool
    {
        return true;
    }
}
