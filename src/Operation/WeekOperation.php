<?php

namespace ConnectHolland\MongoAggregations\Operation;

/**
 * Operation to add a week number.
 *
 * @author Ron Rademaker
 */
class WeekOperation extends AbstractOperation implements ProjectOperationInterface
{
    /**
     * Sets the operation.
     */
    public function __construct()
    {
        $this->setOperationType('$week');
    }

    /**
     * Sets the date field to create week numbers from.
     *
     * @param mixed arguments
     */
    public function setDatefield($field)
    {
        if (is_scalar($field)) {
            if (strpos($field, '$') !== 0) {
                $field = '$'.$field;
            }
            $this->setArguments($field);
        } else {
            throw new InvalidAggregationOperationArgument('WeekOperation only allows scalar arguments');
        }
    }
}
