<?php

namespace League\Functional;

use League\Functional\Contracts\Collectible;
use Iterator;
use InvalidArgumentException;
use League\Functional\Traits\IteratorTrait;

class Collection implements Iterator
{

    use IteratorTrait;

    /**
     * Create a new Collection Instance
     */
    public function __construct($dataset = [])
    {
        $this->items = $this->getCollectibleItems($dataset);
    }

    /**
     * Apply map function to items
     *
     * @param  function  $function
     * @return Collection
     */
    public function map(callable $function)
    {
        $this->items = array_map($function, $this->items);
        return $this;
    }

    /**
     * Apply reduce function to items
     *
     * @param  function  $function
     * @return mixed
     */
    public function reduce(callable $function, $initial = null)
    {
        return array_reduce($this->items, $function, $initial);
    }

    /**
     * Results array of items from Collection or Collectible dataset.
     *
     * @param  mixed  $items
     * @return array
     */
    private function getCollectibleItems($items)
    {
        if (is_array($items)) {
            return $items;
        } elseif ($items instanceof self) {
            return $items->all();
        } elseif ($items instanceof Collectible) {
            return $items->toCollection();
        }
        throw new InvalidArgumentException("Not valid data");
    }
}
