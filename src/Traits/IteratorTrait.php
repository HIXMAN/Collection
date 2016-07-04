<?php

namespace League\Collection\Traits;

use League\Collection\CollectionFactory;

trait IteratorTrait
{
    private $items = [];
    private $index = 0;

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
     * Add a item to dataset
     *
     * @param  mixed  $value
     * @return IteratorTrait
     */
    public function add($value)
    {
        $this->items[] = $value;
        return $this;
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
            $this->items[$key] = new self([$value]);
        }
        return $this;
    }

    /**
     * Add a item to dataset attached to a key
     *
     * @param  mixed  $key
     * @param  mixed  $value
     * @return IteratorTrait
     */
    public function items($items)
    {
        $this->items = $items;
        return $this;
    }

    /**
     * Results array of items from IteratorTrait or Arrayable.
     *
     * @return array
     */
    public function all()
    {
        return $this->items;
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
}
