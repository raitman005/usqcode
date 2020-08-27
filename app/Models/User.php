<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Notifications\ResetPassword as ResetPasswordNotification;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'lastname', 'firstname', 'real_estate_license_number', 'phone_number', 'company'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
    * Check if the user has contains a role
    * 
    * @param <string> $role - The role name 
    *
    * @return boolean true has role, false otherwise
    */

    public function hasRole($roleName) 
    {
        $role = $this->role->where('role', $roleName)->first();
        return $role ? true : false;
    }

    /**
     * A user can have multiple listings / apartments
     *
     * @return HasMany the apartments.
     */
    public function apartments() : HasMany
    {
        return $this->hasMany(Apartment::class);
    }    

    /**
     * A user has status
     *
     * @return BelongsTo the user's status.
     */
    public function userStatus() : BelongsTo
    {
        return $this->belongsTo(UserStatus::class);
    }


    /**
     * A user belongs has a type
     *
     * @return BelongsTo the user type.
     */
    public function userType() : BelongsTo
    {
        return $this->belongsTo(UserType::class);
    }

}
