<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'color',
    ];

    /**
     * An apartment belongs to landlord
     *
     * @return BelongsTo the landlord owner.
     */
    public function landlord() : BelongsTo
    {
        return $this->belongsTo(Landlord::class);
    }

    /**
     * A tag can be assigned to one or more apartments
     *
     * @return BelongsToMany the apartment.
     */
    public function apartments() : BelongsToMany
    {
        return $this->belongsToMany(LeadApartment::class, 'apartment_tag');
    }
}
