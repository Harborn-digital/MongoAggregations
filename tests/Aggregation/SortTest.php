<?php

namespace ConnectHolland\MongoAggregations\Aggregation\Test;

use ConnectHolland\MongoAggregations\Aggregation\Sort;
use ConnectHolland\MongoAggregations\Test\AbstractTestCase;

/**
 * Unit test for the sort stage.
 *
 * @author Ron Rademaker
 */
class SortTest extends AbstractTestCase
{
    /**
     * Test sorting some data.
     */
    public function testSortData()
    {
        $testData = [
            ['foo' => 1],
            ['foo' => 54],
            ['foo' => 2],
            ['foo' => 5],
            ['foo' => 435],
            ['foo' => 17],
        ];

        foreach ($testData as $test) {
            $this->collection->save($test);
        }

        $sort = new Sort();
        $sort->addSort('foo', -1);

        $result = $this->collection->aggregate([$sort->getStage()], ['cursor' => ['batchSize' => 101]]);

        $max = 500;
        foreach ($result['result'] as $record) {
            $this->assertLessThan($max, $record['foo']);
            $max = $record['foo'];
        }
    }
}
