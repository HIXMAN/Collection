<?php

namespace League\Collection\Test;


use InvalidArgumentException;
use League\Collection\Collection;
use League\Collection\Test\BaseTest\BaseTest;

class IteratorTraitTest extends BaseTest
{

    /**
     * Test Collection is Iterator
     */
    public function test_iterators_method()
    {
        $collection = new Collection([1,2,3,4,5]);

        $keyTest = $collection->key() == 0;
        $collection->next();
        $nextTest = $collection->current() == 2;
        $collection->rewind();
        $currentTest = $collection->current() == 1;
        $validTest = $collection->valid();
        $collection->next();
        $collection->next();
        $collection->rewind();
        $rewindTest = $collection->current() == 1;

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
        $collection = new Collection([1,2,3,4,5]);
        $collection2 = new Collection([1,2,3,4,5]);
        $expectedCollection = new Collection([1,2,3,4]);
        $expectedResult = 5;

        $result = $collection->last();
        $this->assertTrue($result == $expectedResult);
        $result = $collection2->last(true);
        $this->assertTrue($result == $expectedResult);

        $this->assertTrue($this->compareTwoCollections($expectedCollection,$collection2));

    }

    /**
     * Test lastItem method
     */
    public function test_first_method()
    {
        $collection = new Collection([1,2,3,4,5]);
        $collection2 = new Collection([1,2,3,4,5]);
        $expectedCollection = new Collection([2,3,4,5]);
        $expectedResult = 1;

        $resultWithoutRemove = $collection->first();
        $this->assertTrue($resultWithoutRemove == $expectedResult);

        $resultWithRemove = $collection2->first(true);
        $this->assertTrue($resultWithRemove == $expectedResult);

        $this->assertTrue($this->compareTwoCollections($expectedCollection,$collection2));
    }

    /**
     * Test not valid data exception is thrown in constructor
     */
    public function test_not_valid_data_excention_is_thrown_in_constructor_method()
    {
        $this->setExpectedException(InvalidArgumentException::class);
        $collection = new Collection(3);
        $collection = new Collection("A string");
    }
}

