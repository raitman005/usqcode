<?php 

namespace App\Helpers;

use Carbon\Carbon;
use \App\Models\UserStatus;
use \App\Models\UserType;
use \App\Models\State;

class Helper
{
    /**
     * User avatar
     *
     * @return string the public path.
     */
    public static function agentAvatar($user)
    {
        if ($user->avatar) {
            return asset("img/avatars/{$user->id}/{$user->avatar}");
        } else {
            return asset("img/default-avatar.jpg");
        }
    }

    /**
     * Get the user status record based on status name
     * 
     * @param $status string
     * 
     * @return UserStatus
     */
    public static function getUserStatus($status)
    {
        return UserStatus::where('status', $status)->first();
    }

    /**
     * Get the user type record based on type name
     * 
     * @param $status string
     * 
     * @return UserType
     */
    public static function getUserType($status)
    {
        return UserType::where('user_type', $status)->first();
    }

    /**
     * Check if password is set or not
     * 
     * @return boolean
     */

    public static function passwordNotSet()
    {
        $user = \Auth::user();
        if (!$user) {
            return false;
        }
        if ($user->password == "") {
            return true;
        }
    }

    /**
     * Return the state id for the given state name
     *
     * @param String $state the state name
     * 
     * @return Integer state ID if state is found, Boolean false otherwise
     */
    public static function getState($state)
    {
        return State::where('state_name', $state)->first()->id ?? false;
    }

    /**
     * Validate base64 image
     *
     * @param String $base64 the state name
     * 
     * @return boolean
     */
    public static function checkIfBase64Image($base64) {
        try {
            $img = imagecreatefromstring(base64_decode($base64));
            if (!$img) {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    
        imagepng($img, 'tmp.png');
        $info = getimagesize('tmp.png');
    
        unlink('tmp.png');
    
        if ($info[0] > 0 && $info[1] > 0 && $info['mime']) {
            return true;
        }
    
        return false;
    }
}