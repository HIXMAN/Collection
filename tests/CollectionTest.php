<?php

namespace League\Collection\Test;

use Iterator;
use League\Collection\Collection;
use League\Collection\Test\BaseTest\BaseTest;

class CollectionTest extends BaseTest
{

    const ODD = "odd";
    const EVEN = "even";
    const SORTER = "sorter";

    /**
     * Test constructor's Collection create and Collection's instance properly
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
     * Test map function
     */
    public function test_map_function()
    {
        $collection =  new Collection([1,2,3,4,5]);
        $expectedArray = new Collection([2,3,4,5,6]);
        $function = function($value)
        {
            return $value+1;
        };

        $collection->map($function);

        $collection = $collection;
        $this->assertTrue($this->compareTwoCollections($collection, $expectedArray));
    }

    /**
     * Test reduce function
     */
    public function test_reduce_function()
    {
        $expectedResult = 4;
        $expectedResultWithInitialStatus = 5;
        $initialStatus = 1;
        $collection =  new Collection([1,1,1,1]);
        $function = function($result,$value)
        {
            return $result + $value;
        };

        $result = $collection->reduce($function);
        $resultWithInitialStatus = $collection->reduce($function,$initialStatus);

        $this->assertTrue($result == $expectedResult);
        $this->assertTrue($resultWithInitialStatus == $expectedResultWithInitialStatus);
    }

    /**
     * Test Collection is Iterator
     */
    public function test_collection_class_is_iterator()
    {
        $collection = new Collection([1,2,3,4]);
        $expectedArray = [2,3,4,5];
        $result = [];
        $summatory = 1;

        foreach ($collection as $item) {
            $result[] = $item + $summatory;
        }

        $collectionIsAInstanceOfIterator = $collection instanceof Iterator;
        $this->assertTrue($collectionIsAInstanceOfIterator);
        $arraysAreEquals = true;
        foreach ($result as $index => $item)
        {
            $arraysAreEquals = $expectedArray[$index] == $item;
        }
        $this->assertTrue($arraysAreEquals);
    }


    /**
     * Test groupBy function works properly
     */
    public function test_group_by_function()
    {
        $collection = new Collection([1,2,3,4,5,6,7,8,9,10]);
        $function = function($item)
        {
            return ($item%2 == 0)?self::EVEN:self::ODD;
        };

        $groupedByOddEven = $collection->groupBy($function);

        $this->assertTrue($this->iterateOddAndEvenAndCheckIfDataIsOddOrEven($groupedByOddEven));
    }

    /**
     * @param $groupedByOddEven
     * @return bool
     */
    private function iterateOddAndEvenAndCheckIfDataIsOddOrEven($groupedByOddEven)
    {
        $testOK = true;
        foreach ($groupedByOddEven->getByKey(self::ODD) as $value) {
            if ($value % 2 == 0) $testOK = false;
        }
        foreach ($groupedByOddEven->getByKey(self::EVEN) as $value) {
            if ($value % 2 != 0) $testOK = false;
        }
        return $testOK;
    }

    /**
     * Test groupBy function
     */
    public function test_sort_by_function()
    {
        $itemsToSort =[
            [self::SORTER =>1],
            [self::SORTER =>5],
            [self::SORTER =>3],
            [self::SORTER =>2],
            [self::SORTER =>4]
        ];
        $expectedArray = [
            [self::SORTER =>1],
            [self::SORTER =>2],
            [self::SORTER =>3],
            [self::SORTER =>4],
            [self::SORTER =>5]
        ];
        $this->collection = new Collection($itemsToSort);
        $expectedCollection = new Collection($expectedArray);
        $function = function($item)
        {
            return $item[self::SORTER];
        };

        $sortedCollection = $this->collection->sortBy($function);

        $this->assertTrue($this->compareTwoCollections($sortedCollection, $expectedCollection));
    }

    /**
     * Test filter method
     */
    public function test_filter_method()
    {
        $this->collection = new Collection([1,2,3,4,5,6,7,8,9,10]);
        $expectedCollection = new Collection([2,4,6,8,10]);
        $function = function ($item)
        {
            return $item % 2 == 0;
        };

        $filteredCollection = $this->collection->filter($function);

        $this->assertTrue($this->compareTwoCollections($expectedCollection,$filteredCollection));
    }
}
