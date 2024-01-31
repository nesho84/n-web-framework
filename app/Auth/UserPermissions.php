<?php

namespace App\Auth;

use App\Core\Sessions;

class UserPermissions
{
    //------------------------------------------------------------
    public static function isOwner(int $ownerId): bool | null
    //------------------------------------------------------------
    {
        $sessionUser = Sessions::get('user');
        $sessionUserRole = $sessionUser['role'];

        // Role 'admin' has all permissions
        if ($sessionUserRole === 'admin') {
            return true;
        }

        // Other roles ('default')
        if ($sessionUser !== null && isset($sessionUser['id'])) {
            if ((int)$sessionUser['id'] === $ownerId) {
                return true;
            }
        }

        return false;
    }
}
