<?php

namespace Teambuilder\model\traits;

use ReflectionClass;
use ReflectionProperty;

trait Children
{

    /**
     * Gets the properties and their values of the instanciated object
     *
     * @return array
     */
    public function toArray(): array
    {
        $properties = [];
        $reflection = new ReflectionClass($this);

        foreach ($reflection->getProperties(ReflectionProperty::IS_PUBLIC) as $key => $value) {
            $value->setAccessible(true);
            $value->getValue($this);
            $properties += [$value->name => $value->getValue($this)];
        }

        return $properties;
    }
}
