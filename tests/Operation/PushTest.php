<?php
namespace ConnectHolland\MongoAggregations\Operation\Test;

use ConnectHolland\MongoAggregations\Operation\Condition;
use ConnectHolland\MongoAggregations\Operation\Push;
use PHPUnit_Framework_TestCase;

/**
 * Unit test for the Push operation
 *
 * @author Ron Rademaker
 */
class PushTest extends PHPUnit_Framework_TestCase
{
    /**
     * Tests if the resulting operation array is as expected
     *
     * @dataProvider providePushTestData
     */
    public function testPush($testData, $expected)
    {
        $push = new Push();
        $push->setPush($testData);
        $result = $push->getOperation();

        $this->assertEquals($expected, $result);
    }

    /**
     * Gets test data
     */
    public function providePushTestData()
    {
        return [
            [
                '$foo',
                [
                    '$push' => '$foo'
                ]
            ],
            [
                Condition::getConditionByIfArray(['$eq' => ['$foo', 'foo']], true, false),
                [
                    '$push' => ['$cond' => [['$eq' => ['$foo', 'foo']], true, false]]
                ]
            ]
        ];
    }
}
