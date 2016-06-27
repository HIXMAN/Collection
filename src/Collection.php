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
     * Add a item to dataset attached to a key
     *
     * @param  mixed  $key
     * @param  mixed  $value
     * @return Collection
     */
    public function addWithKey($key, $value)
    {
        if (isset($this->items[$key])) {
            $this->items[$key]->add($value);
        } else {
            $this->items[$key] = new Collection([$value]);
        }
        return $this;
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
    public function sortBy(callable $function, $descending = false)
    {
        $sortedItems = array_map(function ($item) use ($function) {
            return $function($item);
        }, $this->items);
        ($descending)?arsort($sortedItems):asort($sortedItems);
        $keys = array_keys($sortedItems);
        $this->items = array_map(function ($key) {
            return $this->items[$key];
        }, $keys);
        return $this;
    }

    /**
     * create an array with n item taken from the beginning
     *
     * @param  function  $numberOfElements
     * @param  bool  $perserveKeys
     * @return Collection
     */
    public function take($numberOfElements, $perserveKeys = true)
    {
        $sliceTaken = array_slice($this->items, 0, $numberOfElements, $perserveKeys);
        $this->items = array_slice($this->items, $numberOfElements);
        return new Collection($sliceTaken);
    }

    /**
     * create an array with n item filtered by given function
     *
     * @param  function  $function
     * @return mixed
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
