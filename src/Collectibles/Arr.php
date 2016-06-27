<?php

namespace League\Functional\Collectibles;

use League\Functional\Contracts\Collectible;
use League\Functional\Traits\IteratorTrait;
use Iterator;

class Arr implements
    Collectible,
    Iterator
{

    use IteratorTrait;

    public function __construct(array $array)
    {
        $this->items = $array;
    }

    public function toCollection()
    {
        return $this->items;
    }
}
