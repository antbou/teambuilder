<?php

namespace Teambuilder\core\controller;

abstract class AbstractController
{
    /**
     * Verifies that the recovered CSRF matches the CRSF of the session
     *
     * @return bool
     */
    public function csrfValidator()
    {
        $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);

        if (isset($token) && $token == $_SESSION['token']) {
            return true;
        }
        return false;
    }
}
