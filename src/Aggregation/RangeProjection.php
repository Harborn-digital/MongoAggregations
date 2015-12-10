<?php

namespace ConnectHolland\MongoAggregations\Aggregation;

use ConnectHolland\MongoAggregations\Operation\Condition;

/**
 * A projection to project ranges into values
 * Example, field foo hold an integer.
 *
 * 0 - 10 projected as low
 * 11 - 20 projected as medium
 * 21+ projected as high
 *
 * @author Ron Rademaker
 */
class RangeProjection extends Projection
{
    /**
     * Adds the ranges projection
     * Ranges array should hold array with label, min and / or max (at least one of min and max is required).
     *
     * @param string $field
     * @param array  $ranges
     */
    public function addRange($field, array $ranges)
    {
        $conditions = [];

        foreach ($ranges as $range) {
            $condition = Condition::getConditionByIfArray(
                self::getMinMaxExpression($field, $range),
                $range['label'],
                '$'.$field
            );

            $conditions[] = $condition;
        }

        $projectionCondition = array_pop($conditions);
        while ($nextCondition = array_pop($conditions)) {
            $nextCondition->setElse($projectionCondition);
            $projectionCondition = $nextCondition;
        }

        $this->includeOperationField($field, $projectionCondition);
    }

    /**
     * Gets the min max expression for the given range.
     *
     * @param string $field
     * @param array  $range
     *
     * @return array
     */
    private function getMinMaxExpression($field, array $range)
    {
        if (
            array_key_exists('min', $range)
            && array_key_exists('max', $range)
            && $range['min'] !== false
            && $range['max'] !== false
            ) {
            return [
                '$and' => [
                    ['$lt' => ['$'.$field, (int) $range['max']]],
                    ['$gte' => ['$'.$field, (int) $range['min']]],
                ],
            ];
        } elseif (array_key_exists('min', $range) && $range['min'] !== false) {
            return ['$gte' => ['$'.$field, (int) $range['min']]];
        } else {
            return ['$lt' => ['$'.$field, (int) $range['max']]];
        }
    }
}
