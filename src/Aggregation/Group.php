<?php

namespace ConnectHolland\MongoAggregations\Aggregation;

use ConnectHolland\MongoAggregations\Operation\GroupOperationInterface;

/**
 * $group stage in the aggregation framework.
 *
 * @author Ron Rademaker
 */
class Group extends AbstractArrayDefinitionAggregation
{
    /**
     * Boolean indicating if the result field is set.
     */
    private $resultFieldSet = false;

    /**
     * Creates a new group.
     */
    public function __construct()
    {
        $this->setAggregationType('$group');
    }

    /**
     * Sets the field to group by.
     *
     * @param string|array $field
     */
    public function setGroupBy($field)
    {
        if (!is_array($field)) {
            $field = [$field];
        }

        $fields = [];

        foreach ($field as $groupField) {
            if (strpos($groupField, '$') !== 0) {
                $groupField = '$'.$groupField;
            }

            $fields[ltrim($groupField, '$')] = $groupField;
        }

        if (count($fields) === 1) {
            $this->setField('_id', array_pop($fields));
        } else {
            $this->setField('_id', $fields);
        }
    }

    /**
     * Sets the result field.
     *
     * @param string                  $resultField
     * @param GroupOperationInterface $operation
     */
    public function setResultField($resultField, GroupOperationInterface $operation)
    {
        if ($this->resultFieldSet === true) {
            throw new InvalidAggregationDefinitionException('A result field is already set, twice is not allowed');
        }

        $this->setField($resultField, $operation->getOperation());
        $this->resultFieldSet = true;
    }
}
