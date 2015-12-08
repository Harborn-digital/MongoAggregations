<?php
namespace ConnectHolland\MongoAggregations\Operation\Test;

use ConnectHolland\MongoAggregations\Operation\FieldOperation;
use ConnectHolland\MongoAggregations\Operation\InvalidAggregationOperationArgument;
use PHPUnit_Framework_TestCase;

/**
 * Tests the field operation
 *
 * @author Ron Rademaker
 */
class FieldOperationTest extends PHPUnit_Framework_TestCase
{
    /**
     * Tests if the field operation gives the correct mongo query
     */
    public function testWeekOperation()
    {
        $field = new FieldOperation();
        $field->setField('foo.bar');

        $this->assertEquals('$foo.bar', $field->getOperation());
    }

    /**
     * Tests if passing in incorrect param throws an exception
     */
    public function testIncorrectFieldThrowsException()
    {
        $this->setExpectedException(InvalidAggregationOperationArgument::class);
        $field = new FieldOperation();
        $field->setField(['foo.bar']);
    }
}
