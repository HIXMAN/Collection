<?php

namespace League\Functional\Collectibles;

use League\Functional\Contracts\Collectible;

/**
 * Created by PhpStorm.
 * User: ismael
 * Date: 22/06/16
 * Time: 14:06
 */
class Arr implements Collectible
{

    private $array;

    public function __construct(array $array)
    {
        $this->array = $array;
    }

    public function toCollection()
    {
        return $this->array;
    }
}