<?php

namespace ConnectHolland\MongoAggregations\Aggregation\Test;

use ConnectHolland\MongoAggregations\Aggregation\Limit;
use ConnectHolland\MongoAggregations\Test\AbstractTestCase;

/**
 * Unit test testing the limit stage.
 *
 * @author Jaap Romijn <jaap@connectholland.nl>
 */
class LimitTest extends AbstractTestCase
{
    /**
     * Test if results are limited.
     */
    public function testResultsAreLimited()
    {
        $testData = [
            ['foo' => ['foo']],
            ['bar' => ['foo', 'bar']],
            ['baz' => ['foo', 'bar', 'baz']],
            ['baz' => ['foo', 'baz']],
        ];

        foreach ($testData as $test) {
            $this->collection->save($test);
        }

        $limit = new Limit();
        $limit->setLimit(2);

        $result = $this->collection->aggregate([$limit->getStage()], ['cursor' => ['batchSize' => 101]]);

        $this->assertEquals(2, count($result['result']), 'Asserting the amount of returned results is limited to the amount of the added Limit stage.');
    }

    /**
     * Test if results are limited.
     */
    public function testResultsAreLimitedByConstructor()
    {
        $testData = [
            ['foo' => ['foo']],
            ['bar' => ['foo', 'bar']],
            ['baz' => ['foo', 'bar', 'baz']],
            ['baz' => ['foo', 'baz']],
        ];

        foreach ($testData as $test) {
            $this->collection->save($test);
        }

        $limit = new Limit(2);

        $result = $this->collection->aggregate([$limit->getStage()], ['cursor' => ['batchSize' => 101]]);

        $this->assertEquals(2, count($result['result']), 'Asserting the amount of returned results is limited to the amount of the added Limit stage.');
    }
}
