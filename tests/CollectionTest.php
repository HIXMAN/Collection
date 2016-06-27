<?php

namespace League\Collection\Test;

use Iterator;
use League\Collection\Collection;
use League\Collection\Test\BaseTest\BaseTest;

class CollectionTest extends BaseTest
{

    /**
     * @var Collection
     */
    protected $collection = null;

    /**
     * Test that constructor's Collection create and Collection's instance properly
     */
    public function test_create_a_collection_instance()
    {
        $emptyArray = [];
        $collection = new Collection([]);

        $collectionFromArray = new Collection($emptyArray);
        $collectionFromCollection = new Collection($collection);

        $this->assertTrue($collectionFromArray instanceof Collection);
        $this->assertTrue($collectionFromCollection instanceof Collection);
    }

    /**
     * Test map function works properly
     */
    public function test_map_function()
    {
        $this->collection =  new Collection([1,2,3,4,5]);
        $expectedArray = new Collection([2,3,4,5,6]);
        $function = function($value)
        {
            return $value+1;
        };

        $this->collection->map($function);

        $collection = $this->collection;
        $this->assertTrue($this->compareTwoCollections($collection, $expectedArray));
    }

    /**
     * Test map function works properly
     */
    public function test_reduce_function()
    {
        $expectedResult = 4;
        $expectedResultWithInitialStatus = 5;
        $initialStatus = 1;
        $this->collection =  new Collection([1,1,1,1]);
        $function = function($result,$value)
        {
            return $result + $value;
        };

        $result = $this->collection->reduce($function);
        $resultWithInitialStatus = $this->collection->reduce($function,$initialStatus);

        $this->assertTrue($result == $expectedResult);
        $this->assertTrue($resultWithInitialStatus == $expectedResultWithInitialStatus);
    }

    /**
     * Test Collection is Iterator
     */
    public function test_collection_class_is_iterator()
    {
        $this->collection = new Collection([1,2,3,4]);
        $expectedArray = [2,3,4,5];
        $result = [];
        $summatory = 1;

        foreach ($this->collection as $item) {
            $result[] = $item + $summatory;
        }

        $collectionIsAInstanceOfIterator = $this->collection instanceof Iterator;
        $this->assertTrue($collectionIsAInstanceOfIterator);
        $arraysAreEquals = true;
        foreach ($result as $index => $item)
        {
            $arraysAreEquals = $expectedArray[$index] == $item;
        }
        $this->assertTrue($arraysAreEquals);
    }

}
