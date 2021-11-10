<?php

namespace Teambuilder\core\traits;

trait ClassToTable
{
    public static function getShortName($classname): string
    {
        return strtolower((new \ReflectionClass($classname))->getShortName()) . 's';
    }
}
