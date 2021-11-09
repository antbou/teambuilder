<?php

namespace Teambuilder\model\traits;

trait Table
{
    public static function getShortName($classname): string
    {
        return strtolower((new \ReflectionClass($classname))->getShortName()) . 's';
    }
}
