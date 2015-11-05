<?php
namespace ConnectHolland\MongoAggregations\Operation\Test;

use ConnectHolland\MongoAggregations\Operation\Condition;
use ConnectHolland\MongoAggregations\Operation\InvalidAggregationOperationArgument;
use PHPUnit_Framework_TestCase;

/**
 * Unit test for the operation $cond
 *
 * @author Ron Rademaker
 */
class ConditionTest extends PHPUnit_Framework_TestCase
{
    /**
     * Tests if setting the if twice triggers an exception
     */
    public function testIfTwiceThrowsException()
    {
        $condition = new Condition();
        $condition->setIfByArray([]);
        $this->setExpectedException(InvalidAggregationOperationArgument::class);
        $condition->setIfByArray([]);
    }

    /**
     * Tests if the resulting operation array is as expected
     *
     * @dataProvider provideConditionTestData
     */
    public function testCondition($testData, $expected)
    {
        $condition = Condition::getConditionByIfArray($testData['if'], $testData['then'], $testData['else']);
        $result = $condition->getOperation();

        $this->assertEquals($expected, $result);
    }

    /**
     * Gets test data
     */
    public function provideConditionTestData()
    {
        $testCondition = Condition::getConditionByIfArray(['$eq' => ['$foo', 'foo']], true, false);

        return [
            [
                [
                    'if' => ['$eq' => ['$foo', 'foo']],
                    'then' => true,
                    'else' => false
                ],
                [
                    '$cond' => [['$eq' => ['$foo', 'foo']], true, false]
                ]
            ],
            [
                [
                    'if' => ['$eq' => ['$foo', 'foo']],
                    'then' => $testCondition,
                    'else' => false
                ],
                [
                    '$cond' => [
                        ['$eq' => ['$foo', 'foo']],
                        ['$cond' => [['$eq' => ['$foo', 'foo']], true, false]],
                        false
                    ]
                ]
            ],
            [
                [
                    'if' => ['$eq' => ['$foo', 'foo']],
                    'then' => true,
                    'else' => $testCondition
                ],
                [
                    '$cond' => [
                        ['$eq' => ['$foo', 'foo']],
                        true,
                        ['$cond' => [['$eq' => ['$foo', 'foo']], true, false]]
                     ]
                ]
            ]
        ];
    }
}
