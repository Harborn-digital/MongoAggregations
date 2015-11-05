<?php
namespace ConnectHolland\MongoAggregations\Aggregation;

use ConnectHolland\MongoAggregations\Operation\GroupOperationInterface;

/**
 * $group stage in the aggregation framework
 *
 * @author Ron Rademaker
 */
class Group extends AbstractArrayDefinitionAggregation
{
    /**
     * Boolean indicating if the result field is set
     */
    private $resultFieldSet = false;

    /**
     * Creates a new group
     */
    public function __construct()
    {
        $this->setAggregationType('$group');
    }

    /**
     * Sets the field to group by
     *
     * @param string $field
     */
    public function setGroupBy($field)
    {
        if (strpos($field, '$') !== 0) {
            $field = '$' . $field;
        }

        $this->setField('_id', $field);
    }

    /**
     * Sets the result field
     *
     * @param string $resultField
     * @param GroupOperationInterface $operation
     */
    public function setResultField($resultField, GroupOperationInterface $operation) {
        if ($this->resultFieldSet === true) {
            throw new InvalidAggregationDefinitionException('A result field is already set, twice is not allowed');
        }

        $this->setField($resultField, $operation->getOperation());
        $this->resultFieldSet = true;
    }

     /**
     * Gets the definition array for the grouping
     *
     * @return array
     */
    protected function getDefinition()
    {
        $definition = parent::getDefinition();
        if (!is_array($definition)) {
            $definition = [];
        }
        return $definition;
    }
}
