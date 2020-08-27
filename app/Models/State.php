<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class State extends Model {
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['state_code', 'state_name'];

    /**
     * A State is in  Agent Checkins
     *
     * @return HasMany The attached aagent checkins.
     */
    public function apartments() : HasMany
    {
        return $this->hasMany(Apartment::class);
    }
}
