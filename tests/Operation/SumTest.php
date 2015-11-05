<?php
namespace ConnectHolland\MongoAggregations\Operation\Test;

use ConnectHolland\MongoAggregations\Operation\Condition;
use ConnectHolland\MongoAggregations\Operation\Sum;
use PHPUnit_Framework_TestCase;

/**
 * Unit test for the Sum operation
 *
 * @author Ron Rademaker
 */
class SumTest extends PHPUnit_Framework_TestCase
{
    /**
     * Tests if the resulting operation array is as expected
     *
     * @dataProvider provideSumTestData
     */
    public function testPush($testData, $expected)
    {
        $sum = new Sum();
        $sum->setSum($testData);
        $result = $sum->getOperation();

        $this->assertEquals($expected, $result);
    }

    /**
     * Gets test data
     */
    public function provideSumTestData()
    {
        return [
            [
                1,
                [
                    '$sum' => 1
                ]
            ],
            [
                Condition::getConditionByIfArray(['$eq' => ['$foo', 'foo']], 1, 2),
                [
                    '$sum' => ['$cond' => [['$eq' => ['$foo', 'foo']], 1, 2]]
                ]
            ]
        ];
    }
}
