<?php

namespace App\Middleware;

use App\Core\Sessions;

class Authorize
{
    /**
     * Middleware: Handle user authentication and session checks
     *
     * @param string $role
     * @return void
     */
    //------------------------------------------------------------
    public function handle(string $role): void
    //------------------------------------------------------------
    {
        // No Session
        if (!Sessions::isLoggedIn()) {
            if ($role === 'auth') {
                redirect(APPURL . '/login');
            }
        }

        // With Session
        if (Sessions::isLoggedIn()) {
            if ($role === 'guest') {
                redirect(APPURL . '/admin');
            } elseif ($role === 'auth') {
                // Trigger the session expiration
                Sessions::sessionExpire();
            }
        }
    }
}
