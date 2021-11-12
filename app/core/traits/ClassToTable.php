<?php

namespace Teambuilder\core\traits;

trait ClassToTable
{
    public static function getShortName($classname): string
    {
        $shortname = (new \ReflectionClass($classname))->getShortName();
        $shortname = (substr($shortname, -1) === 's') ? $shortname : $shortname . 's';

        return strtolower($shortname);
    }
}
