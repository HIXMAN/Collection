<?php

namespace League\Collection\Test;


use InvalidArgumentException;
use League\Collection\Collection;
use League\Collection\Test\BaseTest\BaseTest;

class IteratorTraitTest extends BaseTest
{

    /**
     * @var Collection
     */
    protected $collection = null;

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

}

