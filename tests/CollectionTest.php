<?php

namespace League\Functional\Test;

use League\Functional\Collection;
use League\Functional\Collectibles\Arr;
use PHPUnit_Framework_TestCase;
use Iterator;


class CollectionTest extends PHPUnit_Framework_TestCase
{
    const ODD = "odd";
    const EVEN = "even";
    const SORTER = "sorter";

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
        $collectible = new Arr([]);
        $collection = new Collection([]);

        $collectionFromArray = new Collection($emptyArray);
        $collectionFromCollectible = new Collection($collectible);
        $collectionFromCollection = new Collection($collection);

        $this->assertTrue($collectionFromArray instanceof Collection);
        $this->assertTrue($collectionFromCollectible instanceof Collection);
        $this->assertTrue($collectionFromCollection instanceof Collection);
    }

    /**
     * Test map function works properly
     */
    public function test_map_function()
    {
        $expectedArray = [2,3,4,5];
        $this->collection =  new Collection([1,2,3,4]);
        $function = function($value)
        {
            return $value+1;
        };

        $this->collection->map($function);

        $collection = $this->collection;
        $testOk = $this->iterateAndMatchWithExpectedArray($collection, $expectedArray);
        $this->assertTrue($testOk);
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
     * Test groupBy function works properly
     */
    public function test_group_by_function()
    {
        $this->collection = new Collection([1,2,3,4,5,6,7,8,9,10]);
        $function = function($item)
        {
            return ($item%2 == 0)?self::EVEN:self::ODD;
        };

        $groupedByOddEven = $this->collection->groupBy($function);

        $testOK = $this->iterateOddAndEvenAndCheckIfDataIsOddOrEven($groupedByOddEven);
        $this->assertTrue($testOK);
    }


    /**
     * Test groupBy resultset are collections
     */
    public function test_group_by_resultset_are_collections()
    {
        $this->collection = new Collection([1,2,3,4,5,6,7,8,9,10]);
        $function = function($item)
        {
            return ($item%2 == 0)?self::EVEN:self::ODD;
        };

        $groupedByOddEven = $this->collection->groupBy($function);

        $testOK = true;
        foreach ($groupedByOddEven as $collection)
        {
            $testOK = $collection instanceof Collection;
        }
        $this->assertTrue($testOK);
    }

    /**
     * Test groupBy function works properly
     */
    public function test_sort_by_function()
    {
        $sorters =[
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
        $this->collection = new Collection($sorters);
        $function = function($item)
        {
            return $item[self::SORTER];
        };

        $sortedCollection = $this->collection->sortBy($function);

        $testOK = $this->iterateAndCheckIfResultMatchesWithExpected($sortedCollection, $expectedArray);
        $this->assertTrue($testOK);
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

    /**
     * Test Collection is Iterator
     */
    public function test_iterators_method()
    {
        $this->collection = new Collection([1,2,3,4]);

        $keyTest = $this->collection->key() == 0;
        $this->collection->next();
        $nextTest = $this->collection->current() == 2;
        $this->collection->rewind();
        $currentTest = $this->collection->current() == 1;
        $validTest = $this->collection->valid();
        $this->collection->next();
        $this->collection->next();
        $this->collection->rewind();
        $rewindTest = $this->collection->current() == 1;

        $this->assertTrue($keyTest);
        $this->assertTrue($nextTest);
        $this->assertTrue($currentTest);
        $this->assertTrue($validTest);
        $this->assertTrue($rewindTest);
    }

    /**
     * Test lastItem method
     */
    public function test_last_method()
    {
        $this->collection = new Collection([1,2,3,4,5]);
        $this->collection2 = new Collection([1,2,3,4,5]);
        $expectedResult = 5;
        $expectedArray = [1,2,3,4];

        $result = $this->collection->last();
        $this->assertTrue($result == $expectedResult);
        $result = $this->collection2->last(true);
        $this->assertTrue($result == $expectedResult);

        $testAllItemsAreEquals = true;
        foreach ($this->collection2 as $index => $item) {
            $testAllItemsAreEquals = $item == $expectedArray[$index];
        }
        $this->assertTrue($testAllItemsAreEquals);
    }

    /**
     * Test lastItem method
     */
    public function test_first_method()
    {
        $this->collection = new Collection([1,2,3,4,5]);
        $this->collection2 = new Collection([1,2,3,4,5]);
        $expectedResult = 1;
        $expectedArray = [2,3,4,5];

        $resultWithoutRemove = $this->collection->first();
        $this->assertTrue($resultWithoutRemove == $expectedResult);

        $resultWithRemove = $this->collection2->first(true);
        $this->assertTrue($resultWithRemove == $expectedResult);

        $testAllItemsAreEquals = true;
        foreach ($this->collection2 as $index => $item) {
            $testAllItemsAreEquals = $item == $expectedArray[$index];
        }
        $this->assertTrue($testAllItemsAreEquals);
    }

    /**
     * Test lastItem method
     */
    public function test_take_method()
    {
        $this->collection = new Collection([1,2,3,4,5]);
        $expectedCollection = new Collection([1,2]);
        $remainingCollection = new Collection([3,4,5]);

        $resultTakingTwoItems = $this->collection->take(2);

        $this->assertTrue($this->compareTwoCollections($expectedCollection,$resultTakingTwoItems));
        $this->assertTrue($this->compareTwoCollections($remainingCollection,$this->collection));
    }

    /**
     * @param $collection
     * @param $expectedArray
     * @return bool
     */
    private function iterateAndMatchWithExpectedArray($collection, $expectedArray)
    {
        $testOk = true;
        $array = $collection->all();
        for ($i = 0; $i < count($expectedArray); $i++) {
            if ($array[$i] != $expectedArray[$i]) $testOk = false;
        }
        return $testOk;
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
     * @param $sortedCollection
     * @param $expectedArray
     * @return bool
     */
    private function iterateAndCheckIfResultMatchesWithExpected($sortedCollection, $expectedArray)
    {
        $testOK = true;
        $sortedArray = $sortedCollection->all();
        for ($i = 0; $i < count($expectedArray); $i++) {
            if ($expectedArray[$i][self::SORTER] != $sortedArray[$i][self::SORTER]) $testOK = false;
        }
        return $testOK;
    }

    /**
     * @param $array1
     * @param $array2
     * @return bool
     */
    private function compareTwoCollections($collection1, $collection2)
    {
        $testOK = true;
        foreach($collection1 as $index => $item){
            $testOK = $item == $collection2->getByKey($index);
        }
        return $testOK;
    }

}
