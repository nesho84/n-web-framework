<?php

namespace App\Auth;

use App\Core\Sessions;

class UserPermissions
{
    private const SUPER_ADMIN = 'super_admin';
    private const ADMIN = 'admin';
    private const DEFAULT = 'default';

    private static array $user;
    private static string $userRole;

    //------------------------------------------------------------
    public function __construct()
    //------------------------------------------------------------
    {
        $this->initialize();
    }

    //------------------------------------------------------------
    private static function initialize(): void
    //------------------------------------------------------------
    {
        if (empty(self::$user)) {
            self::$user = Sessions::get('user') ?? [];
            self::$userRole = self::$user['role'] ?? '';
        }
    }

    //------------------------------------------------------------
    public static function canView(): bool
    //------------------------------------------------------------
    {
        self::initialize();

        return self::$userRole === self::SUPER_ADMIN ||
            self::$userRole === self::ADMIN;
    }

    //------------------------------------------------------------
    public static function canEdit(int $targeId, string $targetRole = ''): bool
    //------------------------------------------------------------
    {
        self::initialize();

        // Super admin
        if (self::$userRole === self::SUPER_ADMIN) {
            return true;
        }

        // User with 'admin' role
        if (self::$userRole === self::ADMIN) {
            if ((int)self::$user['id'] === $targeId || $targetRole === self::DEFAULT) {
                return true;
            }
        }

        // Default users
        if (self::$userRole === self::DEFAULT) {
            if ((int)self::$user['id'] === $targeId) {
                return true;
            }
        }

        return false;
    }

    //------------------------------------------------------------
    public static function canDelete(int $targeId, string $targetRole = ''): bool
    //------------------------------------------------------------
    {
        self::initialize();

        // Super admin
        if (self::$userRole === self::SUPER_ADMIN) {
            // if ($targetRole === self::SUPER_ADMIN) {
            //     return false;
            // }
            return true;
        }

        // User with 'admin' role
        if (self::$userRole === self::ADMIN) {
            if ((int)self::$user['id'] === $targeId || $targetRole === self::DEFAULT) {
                return true;
            }
        }

        // Default users
        if (self::$userRole === self::DEFAULT) {
            if ((int)self::$user['id'] === $targeId) {
                return true;
            }
        }

        return false;
    }
}
