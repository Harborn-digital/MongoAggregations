<?php
namespace ConnectHolland\MongoAggregations\Operation;

/**
 * Operation to add a week number
 *
 * @author Ron Rademaker
 */
class WeekOperation extends AbstractOperation implements ProjectOperationInterface
{
    /**
     * Sets the date field to create week numbers from
     *
     * @param mixed arguments
     */
    public function setDatefield($field)
    {
        if (is_scalar($field)) {
            if (strpos($field, '$') !== 0) {
                $field = '$' . $field;
            }
            $this->setArguments(['$week' => $field]);
        } else {
            throw new InvalidAggregationOperationArgument('WeekOperation only allows scalar arguments');
        }
    }

    /**
     * Sets the field to add the week number under
     *
     * @param string $field
     */
    public function setWeekField($field)
    {
        if (is_scalar($field)) {
            parent::setOperationType($field);
        } else {
            throw new InvalidAggregationOperationArgument('WeekOperation only allows scalar arguments');
        }
   }
}
