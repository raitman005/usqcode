<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class LeadTag extends Model {
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
    protected $table = 'tags';

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
     * A tag can be assigned to one or more apartments
     *
     * @return BelongsToMany the apartment.
     */
    public function apartments() : BelongsToMany
    {
        return $this->belongsToMany(LeadApartment::class, 'apartment_tag', 'tag_id', 'apartment_id');
    }
}
