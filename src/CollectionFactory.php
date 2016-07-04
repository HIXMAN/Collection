<?php

namespace League\Collection;

use League\Collection\Contracts\Factory;

class CollectionFactory
{

    public static function create(array $dataset = [])
    {
        return new Collection($dataset);
    }
}
