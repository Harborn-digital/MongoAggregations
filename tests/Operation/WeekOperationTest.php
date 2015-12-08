<?php
namespace ConnectHolland\MongoAggregations\Operation\Test;

use ConnectHolland\MongoAggregations\Operation\InvalidAggregationOperationArgument;
use ConnectHolland\MongoAggregations\Operation\WeekOperation;
use PHPUnit_Framework_TestCase;

/**
 * Tests the week operation
 *
 * @author Ron Rademaker
 */
class WeekOperationTest extends PHPUnit_Framework_TestCase
{
    /**
     * Tests if the week operation gives the correct mongo query
     */
    public function testWeekOperation()
    {
        $week = new WeekOperation();
        $week->setDatefield('date');
        $week->setWeekField('week');

        $this->assertEquals(['week' => ['$week' => '$date']], $week->getOperation());
    }

    /**
     * Tests if passing in incorrect param throws an exception
     */
    public function testIncorrectDateFieldThrowsException()
    {
        $this->setExpectedException(InvalidAggregationOperationArgument::class);
        $week = new WeekOperation();
        $week->setDatefield(['date']);
    }

    /**
     * Tests if passing in incorrect param throws an exception
     */
    public function testIncorrectWeekFieldThrowsException()
    {
        $this->setExpectedException(InvalidAggregationOperationArgument::class);
        $week = new WeekOperation();
        $week->setWeekField(['week']);
    }
}
