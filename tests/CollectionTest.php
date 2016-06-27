<?php

namespace League\Functional\Test;

use Iterator;
use InvalidArgumentException;
use PHPUnit_Framework_TestCase;
use League\Functional\Collection;
use League\Functional\Collectibles\Arr;


class CollectionTest extends PHPUnit_Framework_TestCase
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

    /**
     * Test Collection is Iterator
     */
    public function test_iterators_method()
    {
        $this->collection = new Collection([1,2,3,4,5]);

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
        $expectedCollection = new Collection([1,2,3,4]);
        $expectedResult = 5;

        $result = $this->collection->last();
        $this->assertTrue($result == $expectedResult);
        $result = $this->collection2->last(true);
        $this->assertTrue($result == $expectedResult);

        $this->assertTrue($this->compareTwoCollections($expectedCollection,$this->collection2));

    }

    /**
     * Test lastItem method
     */
    public function test_first_method()
    {
        $this->collection = new Collection([1,2,3,4,5]);
        $this->collection2 = new Collection([1,2,3,4,5]);
        $expectedCollection = new Collection([2,3,4,5]);
        $expectedResult = 1;

        $resultWithoutRemove = $this->collection->first();
        $this->assertTrue($resultWithoutRemove == $expectedResult);

        $resultWithRemove = $this->collection2->first(true);
        $this->assertTrue($resultWithRemove == $expectedResult);

        $this->assertTrue($this->compareTwoCollections($expectedCollection,$this->collection2));
    }

    /**
     * Test not valid data exception is thrown in constructor
     */
    public function test_not_valid_data_excention_is_thrown_in_constructor_method()
    {
        $this->setExpectedException(InvalidArgumentException::class);
        $this->collection = new Collection(3);
        $this->collection = new Collection("A string");
    }

    /**
     * @param $array1
     * @param $array2
     * @return bool
     */
    private function compareTwoCollections($collection1, $collection2)
    {
        $testOK = true;
        if ($collection1->lenght() != $collection2->lenght()){
            return false;
        }
        foreach($collection1 as $index => $item){
            if ($item != $collection2->getByKey($index)){
                return false;
            }
        }
        return $testOK;
    }

}
