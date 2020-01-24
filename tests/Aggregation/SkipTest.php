<?php

namespace ConnectHolland\MongoAggregations\Aggregation\Test;

use ConnectHolland\MongoAggregations\Aggregation\Skip;
use ConnectHolland\MongoAggregations\Test\AbstractTestCase;

/**
 * Unit test testing the skip stage.
 *
 * @author Jaap Romijn <jaap@connectholland.nl>
 */
class SkipTest extends AbstractTestCase
{
    /**
     * Test if results are skipped.
     */
    public function testResultsAreSkipped()
    {
        $testData = [
            ['foo' => '1'],
            ['foo' => '2'],
            ['foo' => '3'],
        ];

        foreach ($testData as $test) {
            $this->collection->save($test);
        }

        $skip = new Skip();
        $skip->setAmount(1);

        $result = $this->collection->aggregate([$skip->getStage()], ['cursor' => ['batchSize' => 101]]);

        $this->assertEquals('2', $result['result'][0]['foo'], 'Asserting results are skipped equal to the amount added Skip stage.');
    }

    /**
     * Test if results are skipped.
     */
    public function testResultsAreSkippedByConstructor()
    {
        $testData = [
            ['foo' => '1'],
            ['foo' => '2'],
            ['foo' => '3'],
        ];

        foreach ($testData as $test) {
            $this->collection->save($test);
        }

        $skip = new Skip(1);

        $result = $this->collection->aggregate([$skip->getStage()], ['cursor' => ['batchSize' => 101]]);

        $this->assertEquals('2', $result['result'][0]['foo'], 'Asserting results are skipped equal to the amount added Skip stage.');
    }
}
