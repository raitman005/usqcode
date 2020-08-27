<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Feature extends Model {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'feature', 'icon',
    ];

    /**
     * A feature can be assigned to one or more apartments
     *
     * @return BelongsToMany the apartment.
     */
    public function apartments() : BelongsToMany
    {
        return $this->belongsToMany(Apartment::class, 'apartment_feature');
    }
}
