<?php

namespace App\Auth;

use App\Core\Sessions;

class UserPermissions
{
    //------------------------------------------------------------
    public static function isOwner(int $ownerId): bool | null
    //------------------------------------------------------------
    {
        // @TODO: musst be also checked the user in the database

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

    //------------------------------------------------------------
    public static function hasViewAccess(): bool
    //------------------------------------------------------------
    {
        $sessionUserRole = Sessions::get('user')['role'];

        if ($sessionUserRole === 'admin')
            return true;

        return false;
    }
}
