<?php
namespace ConnectHolland\MongoAggregations\Aggregation;

use ConnectHolland\MongoAggregations\Operation\Condition;
use ConnectHolland\MongoAggregations\Operation\Push;

/**
 * Bag of aggregations supporting mixed database field
 *
 * Not recommended (keep your db clean)
 *
 * @author Ron Rademaker
 */
class MixedFieldsBag extends AggregationBag
{
    /**
     * Creates a mixed field bag for $field
     *
     * @param string $field
     */
    public function __construct($field)
    {
        $this->addAggregation($this->getProjection($field));
        $this->addAggregation($this->getUnwind($field));
        $this->addAggregation($this->getGroup($field));
    }

    /**
     * Gets the projection part of the pipeline
     *
     * @param string $field
     */
    private function getProjection($field)
    {
        $projection = new Projection();
        $projection->includeField($field);

        $originalCondition = Condition::getConditionByIfArray(
            ['$gte' => ['$' . $field, []]],
            null,
            '$' . $field
        );

        $unWrappedCondition = Condition::getConditionByIfArray(
            ['$gte' => ['$' . $field, []]],
            '$' . $field,
            [1]
        );

        $projection->includeOperationField($field . '_original', $originalCondition);
        $projection->includeOperationField($field . '_unwrapped', $unWrappedCondition);

        return $projection;
    }

    /**
     * Gets the unwind part
     *
     * @param string $field
     */
    private function getUnwind($field)
    {
        $unwind = new Unwind();
        $unwind->setField($field . '_unwrapped');

        return $unwind;
    }

    /**
     * Gets the grouping that groups everything in an array
     *
     * @param string $field
     */
    private function getGroup($field)
    {
        $group = new Group();
        $group->setGroupBy('_id');

        $condition = Condition::getConditionByIfArray(
            ['$gte' => ['$' . $field, []]],
            '$' . $field . '_unwrapped',
            '$' . $field . '_original'
        );

        $push = new Push();
        $push->setPush($condition);
        $group->setResultField($field, $push);

        return $group;
    }
}
