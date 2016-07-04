<?php

namespace League\Collection\Test\BaseTest;

use League\Collection\Collection;
use PHPUnit_Framework_TestCase;

abstract class BaseTest extends PHPUnit_Framework_TestCase
{

    /**
     * @param $array1
     * @param $array2
     * @return bool
     */
    public function compareTwoCollections($collection1, $collection2)
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