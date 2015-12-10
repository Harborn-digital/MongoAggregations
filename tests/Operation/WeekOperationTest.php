<?php

namespace ConnectHolland\MongoAggregations\Operation\Test;

use ConnectHolland\MongoAggregations\Aggregation\Projection;
use ConnectHolland\MongoAggregations\Operation\InvalidAggregationOperationArgument;
use ConnectHolland\MongoAggregations\Operation\WeekOperation;
use ConnectHolland\MongoAggregations\Test\AbstractTestCase;
use MongoDate;

/**
 * Tests the week operation.
 *
 * @author Ron Rademaker
 */
class WeekOperationTest extends AbstractTestCase
{
    /**
     * Tests if the week operation gives the correct mongo query.
     */
    public function testWeekOperation()
    {
        $week = new WeekOperation();
        $week->setDatefield('date');

        $this->assertEquals(['$week' => '$date'], $week->getOperation());
    }

    /**
     * Tests if passing in incorrect param throws an exception.
     */
    public function testIncorrectDateFieldThrowsException()
    {
        $this->setExpectedException(InvalidAggregationOperationArgument::class);
        $week = new WeekOperation();
        $week->setDatefield(['date']);
    }

    /**
     * Test projecting week numbers.
     */
    public function testProjectWeekNumber()
    {
        $testData = [
            ['foo' => new MongoDate(strtotime('2015W10')), 'expected' => strftime('%U', strtotime('2015W10'))],
            ['foo' => new MongoDate(strtotime('2015W20')), 'expected' => strftime('%U', strtotime('2015W20'))],
            ['foo' => new MongoDate(strtotime('2015W25')), 'expected' => strftime('%U', strtotime('2015W25'))],
        ];

        foreach ($testData as $test) {
            $this->collection->save($test);
        }

        $week = new WeekOperation();
        $week->setDatefield('foo');

        $projection = new Projection();
        $projection->includeField('expected');
        $projection->includeOperationField('weeknumber', $week);

        $result = $this->collection->aggregate([$projection->getStage()]);

        $this->assertEquals(3, count($result['result']));

        foreach ($result['result'] as $record) {
            $this->assertEquals($record['expected'], $record['weeknumber']);
        }
    }
}
