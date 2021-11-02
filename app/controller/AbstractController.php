<?php

namespace Teambuilder\controller;

abstract class AbstractController
{
    /**
     * Verifie que le CSRF récupèrer correspont au CRSF de la session
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
