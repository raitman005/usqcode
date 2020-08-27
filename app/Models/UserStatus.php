<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserStatus extends Model {
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['status'];

    /**
     * A UserStatus is in  Users
     *
     * @return HasMany The attached users.
     */
    public function users() : HasMany
    {
        return $this->hasMany(User::class);
    }
}
