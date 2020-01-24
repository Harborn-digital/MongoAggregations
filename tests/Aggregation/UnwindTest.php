<?php

namespace ConnectHolland\MongoAggregations\Aggregation\Test;

use ConnectHolland\MongoAggregations\Aggregation\Unwind;
use ConnectHolland\MongoAggregations\Test\AbstractTestCase;

/**
 * Unit test testing the unwind stage.
 *
 * @author Ron Rademaker
 */
class UnwindTest extends AbstractTestCase
{
    /**
     * Test if fields are unwinded.
     */
    public function testFieldsAreIncluded()
    {
        $testData = [
            ['foo' => ['foo']],
            ['foo' => ['foo', 'bar', 'baz']],
        ];

        foreach ($testData as $test) {
            $this->collection->save($test);
        }

        $unwind = new Unwind();
        $unwind->setField('foo');

        $result = $this->collection->aggregate([$unwind->getStage()], ['cursor' => ['batchSize' => 101]]);

        $this->assertEquals(4, count($result['result']));
    }
}
