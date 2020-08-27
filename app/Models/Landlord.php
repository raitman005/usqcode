<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Landlord extends Model {
    /**
     * The connection used
     * 
     * @var String
     */
    protected $connection = 'mysql2';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'dogs_allowed', 
        'cats_allowed',
        'streets',
        'url'
    ];

    /**
     * A landlord has many apartments
     *
     * @return HasMany The apartments of the landlord.
     */
    public function apartments() : HasMany
    {
        return $this->hasMany(Apartment::class);
    }

}
