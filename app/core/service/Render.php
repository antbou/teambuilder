<?php

namespace Teambuilder\core\service;

class Render
{
    /**
     * Allows to generate page rendering
     *
     * @param string $path
     * @param array $variables
     * @return void
     */
    public static function render(string $path, array $variables = [], bool $hasForm = false)
    {

        if ($hasForm) {
            $_SESSION['token'] = md5(uniqid(mt_rand(), true));
        }

        // Extract the variables from the table
        extract($variables);

        // All the following data will be stored in a temporary buffer 
        ob_start();
        require('app/view/' . $path . '.html.php');

        // retrieves the content of the buffer and deletes it
        $pageContent = ob_get_clean();

        require('app/view/base.html.php');
    }
}
