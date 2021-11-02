<?php

namespace Teambuilder\core\service;

use Teambuilder\core\service\Render;


class Http
{

    public static function notFoundException(): void
    {
        http_response_code(404);
        Render::render('errors/404');
    }

    public static function redirectToUrl(string $url): void
    {
        header("Location: $url");
        exit();
    }

    public static function response(string $path, array $variables = [], bool $hasForm = false, int $responseCode = 200): void
    {
        http_response_code($responseCode);
        Render::render($path, $variables, $hasForm);
    }
}
