<?php

namespace League\Functional;

use League\Functional\Contracts\Collectible;

class Collection
{

    private $items;

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
     * Results array of items from Collection or Arrayable.
     *
     * @param  function  $function
     * @return Collection
     */
    public function addWithKey($key,$value)
    {
        $this->items[$key] = $value;
    }

    /**
     * Apply map function to items
     *
     * @param  function  $function
     * @return Collection
     */
    public function map(callable $function)
    {
        $this->items = array_map($function,$this->items);
        return $this;
    }

    /**
     * Apply reduce function to items
     *
     * @param  function  $function
     * @return mixed
     */
    public function reduce(callable $function,$initial = null)
    {
        return array_reduce($this->items,$function,$initial);
    }

    /**
     * Group by given function
     *
     * @param  function  $function
     * @return mixed
     */
    public function groupBy(callable $function = null)
    {

        return $this->reduce(function($result,$item) use ($function)
        {
//            $this->addWithKey($function($item),$item);
            $result[$function($item)][] = $item;
            return $result;
        },[]);
    }


    /**
     * Sort by given function
     *
     * @param  function  $function
     * @return mixed
     */
    public function sortBy(callable $function,$descending = false)
    {
        $sortedItems = array_map(function($item) use ($function) {
            return $function($item);
        },$this->items);
        ($descending)?arsort($sortedItems):asort($sortedItems);
        $keys = array_keys($sortedItems);
        $this->items = array_map(function($key){
            return $this->items[$key];
        },$keys);
        return $this;
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
    }

}
