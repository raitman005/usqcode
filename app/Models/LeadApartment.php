<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeadApartment extends Model {
    use SoftDeletes;
    
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
    protected $table = 'apartments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'price',
        'bedrooms',
        'bathrooms',
        'description',
        'street',
        'remarks',
        'date',
        'landlord_id',
        'apartment_number',
        'rented_at',
        'latitude',
        'longitude',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

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
     * An apartment can have many tags
     *
     * @return BelongsToMany the tags.
     */
    public function tags() : BelongsToMany
    {
        return $this->belongsToMany(LeadTag::class, 'apartment_tag', 'apartment_id', 'tag_id');
    }   

    /**
     * An apartment has many photos
     * 
     * @return HasMany the photos
     */
    public function apartmentPhotos()
    {
        return $this->hasMany(LeadApartmentPhoto::class, 'apartment_id');
    }

    /**
     * An apartment can have many features
     *
     * @return BelongsToMany the features.
     */
    public function features() : BelongsToMany
    {
        return $this->belongsToMany(LeadFeature::class, 'apartment_feature', 'apartment_id', 'feature_id')->withTimestamps();
    }   

    /**
     * An apartment can have a neighborhood
     *
     * @return belongsTo the neighborhood.
     */
    public function neighborhood() : belongsTo
    {
        return $this->belongsTo(LeadNeighborhood::class);
    }   
}
