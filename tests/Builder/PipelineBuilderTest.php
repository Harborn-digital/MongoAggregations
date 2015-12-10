<?php

namespace ConnectHolland\MongoAggregations\Builder\Test;

use ConnectHolland\MongoAggregations\Aggregation\AggregationBag;
use ConnectHolland\MongoAggregations\Aggregation\AggregationInterface;
use ConnectHolland\MongoAggregations\Aggregation\Unwind;
use ConnectHolland\MongoAggregations\Builder\PipelineBuilder;
use PHPUnit_Framework_TestCase;

/**
 * Unit test for the pipeline builder.
 *
 * @author Ron Rademaker
 */
class PipelineBuilderTest extends PHPUnit_Framework_TestCase
{
    /**
     * Tests if the resulting aggregation array is as expected.
     *
     * @dataProvider provideAggregationPipelineTestData
     */
    public function testPipelineBuilder($testData, $expected)
    {
        $builder = new PipelineBuilder();
        foreach ($testData as $part) {
            if ($part instanceof AggregationInterface) {
                $builder->add($part);
            } elseif ($part instanceof AggregationBag) {
                $builder->addBag($part);
            } elseif ($part instanceof PipelineBuilder) {
                $builder->addBuilder($part);
            }
        }

        $result = $builder->build();

        $this->assertEquals($expected, $result);
    }

    /**
     * Gets test data for the pipeline builder.
     */
    public function provideAggregationPipelineTestData()
    {
        $unwind1 = new Unwind();
        $unwind1->setField('foo');
        $unwind2 = new Unwind();
        $unwind2->setField('bar');
        $unwind3 = new Unwind();
        $unwind3->setField('baz');

        $bag = new AggregationBag();
        $bag->addAggregation($unwind2);

        $builder = new PipelineBuilder();
        $builder->add($unwind3);

        return [
            [
                [
                    $unwind1,
                ],
                [
                    ['$unwind' => '$foo'],
                ],
            ],
            [
                [
                    $bag,
                ],
                [
                    ['$unwind' => '$bar'],
                ],
            ],
            [
                [
                    $builder,
                ],
                [
                    ['$unwind' => '$baz'],
                ],
            ],
            [
                [
                    $unwind1,
                    $bag,
                    $builder,
                ],
                [
                    ['$unwind' => '$foo'],
                    ['$unwind' => '$bar'],
                    ['$unwind' => '$baz'],
                ],
            ],
        ];
    }
}
