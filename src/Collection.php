<?php

namespace League\Functional;

use League\Functional\Contracts\Collectible;
use Iterator;
use InvalidArgumentException;

class Collection implements Iterator
{
    private $items = null;
    private $index = 0;

    /**
     * Create a new Collection Instance
     */
    public function __construct($dataset = [])
    {
        $this->items = $this->getCollectibleItems($dataset);
    }

    /**
     * Results array of items from Collection or Arrayable.
     *
     * @param  function  $function
     * @return Collection
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * Add a item to dataset attached to a key
     *
     * @param  mixed  $key
     * @param  mixed  $value
     * @return Collection
     */
    public function add($value)
    {
        $this->items[] = $value;
        return $this;
    }

    /**
     * Return length of dataset
     *
     * @return int
     */
    public function lenght()
    {
        return count($this->items);
    }

    /**
     * Get the last item from dataset
     *
     * @return mixed
     */
    public function last($remove = false)
    {
        if ($remove) {
            return array_pop($this->items);
        }
        return $this->items[count($this->items)-1];
    }

    /**
     * Get the first item from dataset
     *
     * @return mixed
     */
    public function first($remove = false)
    {
        if ($remove) {
            return array_shift($this->items);
        }
        return $this->items[0];
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
     * Get a item from dataset by key
     *
     * @param  mixed  $key
     * @return Mixed
     */
    public function getByKey($key)
    {
        return $this->items[$key];
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

    /**
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        return $this->items[$this->index];
    }

    /**
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        $this->index ++;
    }

    /**
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return $this->index;
    }

    /**
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return isset($this->items[$this->index]);
    }

    /**
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->index = 0;
    }
}
