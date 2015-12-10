<?php

namespace ConnectHolland\MongoAggregations\Aggregation\Test;

use ConnectHolland\MongoAggregations\Aggregation\RangeProjection;
use ConnectHolland\MongoAggregations\Test\AbstractTestCase;

/**
 * Unit test for the range project stage.
 *
 * @author Ron Rademaker
 */
class RangeProjectionTest extends AbstractTestCase
{
    /**
     * Basic range testing.
     */
    public function testRangeProjection()
    {
        $testData = [
            ['foo' => 1],
            ['foo' => 2],
            ['foo' => 3],
            ['foo' => 5],
            ['foo' => 11],
            ['foo' => 15],
            ['foo' => 22],
            ['foo' => 29],
        ];

        foreach ($testData as $test) {
            $this->collection->save($test);
        }

        $ranges = [
            ['label' => 'low', 'max' => 10],
            ['label' => 'medium', 'min' => 11, 'max' => 20],
            ['label' => 'high', 'min' => 21],
        ];

        $rangedProjection = new RangeProjection();
        $rangedProjection->addRange('foo', $ranges);

        $result = $this->collection->aggregate([$rangedProjection->getStage()]);

        $this->assertEquals(count($testData), count($result['result']));
        $lows = 0;
        $mediums = 0;
        $highs = 0;

        foreach ($result['result'] as $res) {
            switch ($res['foo']) {
                case 'high':
                    $highs++;
                    break;
                case 'medium':
                    $mediums++;
                    break;
                case 'low':
                    $lows++;
                    break;
            }
        }

        $this->assertEquals(4, $lows);
        $this->assertEquals(2, $mediums);
        $this->assertEquals(2, $highs);
    }
}
