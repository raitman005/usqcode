<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Lead extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'body',
        'apartment_id',
    ];

    /**
     * A lead belongs to the apartment
     *
     * @return BelongsTo the apartment.
     */
    public function apartment() : BelongsTo
    {
        return $this->belongsTo(Apartment::class);
    }
}
