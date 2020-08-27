<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ApartmentPhoto extends Model {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'apartment_id',
        'photo',
    ];

    /**
     * An apartment photo belongs to apartment
     *
     * @return BelongsTo the apartment.
     */
    public function apartment() : BelongsTo
    {
        return $this->belongsTo(Apartment::class);
    }
}
