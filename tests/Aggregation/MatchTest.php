<?php

namespace ConnectHolland\MongoAggregations\Aggregation\Test;

use ConnectHolland\MongoAggregations\Aggregation\Match;
use ConnectHolland\MongoAggregations\Test\AbstractTestCase;

/**
 * Unit test for the $match state.
 *
 * @author Ron Rademaker
 */
class MatchTest extends AbstractTestCase
{
    /**
     * Tests grouping some data.
     */
    public function testGroupData()
    {
        $testData = [
            ['foo' => 'foo'],
            ['foo' => 'foo'],
            ['foo' => 'bar'],
            ['foo' => 'bar'],
            ['foo' => 'bar'],
        ];

        foreach ($testData as $test) {
            $this->collection->save($test);
        }

        $match = new Match();
        $match->setQuery(['foo' => 'foo']);

        $result = $this->collection->aggregate([$match->getStage()], ['cursor' => ['batchSize' => 101]]);

        $this->assertEquals(2, count($result['result']));
    }
}
