<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Apartment extends Model {
    use SoftDeletes;

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
        'available_date',
        'apartment_number',
        'state_id',
        'landlord',
        'apartment_number',
        'rented_at',
        'latitude',
        'longitude',
        'user_id',
        'neighborhood_id',
        'source_apartment_id',
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
        return $this->belongsToMany(Tag::class, 'lead_contractor.apartment_tag');
    }   

    /**
     * An apartment has many photos
     * 
     * @return HasMany the photos
     */
    public function apartmentPhotos()
    {
        return $this->hasMany(ApartmentPhoto::class)->orderBy('order');
    }

    /**
     * An apartment can have many features
     *
     * @return BelongsToMany the features.
     */
    public function features() : BelongsToMany
    {
        return $this->belongsToMany(Feature::class, 'apartment_feature')->withTimestamps();
    }   

    /**
     * An apartment can have a neighborhood
     *
     * @return belongsTo the neighborhood.
     */
    public function neighborhood() : belongsTo
    {
        return $this->belongsTo(Neighborhood::class);
    }   

    /**
     * An apartment can have a leads
     *
     * @return HasMany the leads.
     */
    public function leads() : HasMany
    {
        return $this->hasMany(Lead::class);
    }   

    /**
     * An apartment is owned / created by the user
     *
     * @return BelongsTo the user owner.
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }   
}
