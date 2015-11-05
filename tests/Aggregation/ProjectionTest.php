<?php
namespace ConnectHolland\MongoAggregations\Aggregation\Test;

use ConnectHolland\MongoAggregations\Aggregation\Projection;
use ConnectHolland\MongoAggregations\Operation\Condition;

/**
 * Unit test to test the $project stage
 *
 * @author Ron Rademaker
 */
class ProjectionTest
{
    /**
     * Test if fields are included
     */
    public function testFieldsAreIncluded()
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

        $projection = new Projection();
        $projection->includeField('foo');

        $result = $this->collection->aggregate([$projection->getStage()]);

        $this->assertEquals(5, count($result['result']));
    }

    /**
     * Test if fields are added
     */
    public function testFieldsAreAdded()
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

        $projection = new Projection();
        $projection->includeField('foo');
        $condition = Condition::getConditionByIfArray(
            ['$eq' => ['foo', 'foo']],
            true,
            false
        );
        $projection->includeOperationField('isFoo', $condition);

        $result = $this->collection->aggregate([$projection->getStage()]);

        $this->assertEquals(5, count($result['result']));

        foreach ($result['result'] as $res) {
            if ($res['foo'] === 'foo') {
                $this->assertTrue($res['isFoo']);
            } else {
                $this->assertFalse($res['isFoo']);
            }
        }
    }
}
