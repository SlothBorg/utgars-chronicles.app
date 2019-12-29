<?php declare(strict_types=1);

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use Notifiable;

    /** @var array */
    protected $guarded = [];

    /** @var array */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /** @var array */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function histories(): HasMany
    {
        return $this->hasMany(History::class, 'owner_id');
    }

    public function games(): BelongsToMany
    {
        return $this->belongsToMany(History::class);
    }
}
