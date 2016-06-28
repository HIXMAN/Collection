<?php

namespace League\Collection\Test;

use League\Collection\Collection;
use League\Collection\Test\BaseTest\BaseTest;

class ConcreteCollectionTest extends BaseTest
{

    const ODD = "odd";
    const EVEN = "even";

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

}