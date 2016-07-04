<?php

namespace League\Collection;

use Iterator;
use InvalidArgumentException;
use League\Collection\Traits\IteratorTrait;
use League\Collection\Contracts\Collectible;

class Collection implements Iterator
{

    use IteratorTrait;

    /**
     * Create a new Collection Instance
     */
    public function __construct($dataset = [])
    {
        $this->items($this->getCollectibleItems($dataset));
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
    public function getCollectibleItems($items)
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

    /**
     * Group by given function
     *
     * @param  function  $function
     * @return mixed
     */
    public function groupBy(callable $function = null)
    {
        return $this->reduce(function ($result, $item) use ($function) {
            return $result->addWithKey($function($item), $item);
        }, new Collection([]));
    }

    /**
     * Sort by given function
     *
     * @param  function  $function
     * @return mixed
     */
    public function sortBy(callable $function = null, $descending = false)
    {
        $itemsToSort = array_map(function ($item) use ($function) {
            return $function($item);
        }, $this->items);
        ($descending)?arsort($itemsToSort):asort($itemsToSort);
        $keys = array_keys($itemsToSort);
        $this->items = array_map(function ($key) {
            return $this->items[$key];
        }, $keys);
        return $this;
    }

    /**
     * create an array with n item filtered by given function
     *
     * @param  function  $function
     * @return Collection
     */
    public function filter(callable $function)
    {
        return $this->reduce(function ($collection, $row) use ($function) {
            if ($function($row)) {
                return $collection->add($row);
            }
            return $collection;
        }, new Collection());
    }
}
