<?php

namespace ConnectHolland\MongoAggregations\Operation\Test;

use ConnectHolland\MongoAggregations\Operation\ArrayOperation;
use ConnectHolland\MongoAggregations\Test\AbstractTestCase;

/**
 * Unit test for the ArrayOperation
 *
 * @author Ron Rademaker
 */
class ArrayOperationTest extends AbstractTestCase
{
    /**
     * Tests if the array operation returns whatever was set.
     */
    public function testArrayOperation()
    {
        $operation = new ArrayOperation(['$year' => '$date']);

        $this->assertEquals(['$year' => '$date'], $operation->getOperation());
    }
}
