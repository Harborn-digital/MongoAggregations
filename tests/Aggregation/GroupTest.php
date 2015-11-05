<?php
namespace ConnectHolland\MongoAggregations\Aggregation\Test;

use ConnectHolland\MongoAggregations\Aggregation\Group;
use ConnectHolland\MongoAggregations\Aggregation\InvalidAggregationDefinitionException;
use ConnectHolland\MongoAggregations\Operation\Sum;
use ConnectHolland\MongoAggregations\Test\AbstractTestCase;

/**
 * Unit test for the $group stage
 *
 * @author Ron Rademaker
 */
class GroupTest extends AbstractTestCase
{
    /**
     * Verifies that trying to add multiple group results leads to an exception
     */
    public function testMultipleResultFieldsThrowsException()
    {
        $group = new Group();
        $sum = new Sum();
        $sum->setSum(1);
        $group->setResultField('result', $sum);
        $this->setExpectedException(InvalidAggregationDefinitionException::class);
        $group->setResultField('result', $sum);
    }

    /**
     * Tests grouping some data
     */
    public function testGroupData()
    {
        $testData = [
            ['foo' => 'foo'],
            ['foo' => 'foo'],
            ['foo' => 'bar'],
            ['foo' => 'bar'],
            ['foo' => 'bar']
        ];

        foreach ($testData as $test) {
            $this->collection->save($test);
        }

        $group = new Group();
        $group->setGroupBy('foo');
        $sum = new Sum();
        $sum->setSum(1);
        $group->setResultField('count', $sum);

        $result = $this->collection->aggregate([$group->getStage()]);

        $foos = 0;
        $bars = 0;

        $this->assertEquals(2, count($result['result']));

        foreach ($result['result'] as $res) {
            switch ($res['_id']) {
                case 'foo':
                    $foos = $res['count'];
                    break;
                case 'bar':
                    $bars = $res['count'];
                    break;
            }
        }

        $this->assertEquals(2, $foos);
        $this->assertEquals(3, $bars);
    }
}
