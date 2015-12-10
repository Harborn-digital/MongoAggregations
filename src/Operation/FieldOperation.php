<?php

namespace ConnectHolland\MongoAggregations\Operation;

/**
 * Operation to add a field under another name.
 *
 * @author Ron Rademaker
 */
class FieldOperation extends AbstractOperation implements ProjectOperationInterface
{
    /**
     * Gets the operation.
     *
     * @return string
     */
    public function getOperation()
    {
        return $this->getArguments();
    }

    /**
     * Sets the field to include.
     *
     * @param mixed arguments
     */
    public function setField($field)
    {
        if (is_scalar($field)) {
            if (strpos($field, '$') !== 0) {
                $field = '$'.$field;
            }
            $this->setArguments($field);
        } else {
            throw new InvalidAggregationOperationArgument('FieldOperation only allows scalar arguments');
        }
    }
}
