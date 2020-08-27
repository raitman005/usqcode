<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class LeadApartmentPhoto extends Model {
    /**
     * The connection used
     * 
     * @var String
     */
    protected $connection = 'mysql2';

    /**
     * The DB table name
     * 
     * @var String
     */
    protected $table = 'apartment_photos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'photo',
    ];

    /**
     * An apartment photo belongs to apartment
     *
     * @return BelongsTo the apartment.
     */
    public function apartment() : BelongsTo
    {
        return $this->belongsTo(LeadApartment::class);
    }
}
