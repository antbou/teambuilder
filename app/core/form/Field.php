<?php

namespace Teambuilder\core\form;

class Field
{
    public string $error;
    public string $name;
    public $type;
    private int $size;
    public bool $canBeEmpty;

    public $value;

    public function __construct(string $name, $type, bool $canBeEmpty = false, int $size = 50)
    {
        $this->name = $name;
        $this->type = $type;
        $this->size = $size;
        $this->canBeEmpty = $canBeEmpty;
    }
}
