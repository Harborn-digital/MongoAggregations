<?php

namespace ConnectHolland\MongoAggregations\Aggregation;

use ConnectHolland\MongoAggregations\Operation\ProjectOperationInterface;

/**
 * Representation of a $project stage.
 *
 * @author Ron Rademaker
 */
class Projection extends AbstractArrayDefinitionAggregation
{
    /**
     * Creates a new projection.
     */
    public function __construct()
    {
        $this->setAggregationType('$project');
    }

    /**
     * Include $field.
     *
     * @param string $field
     */
    public function includeField($field)
    {
        $this->setField($field, 1);
    }

    /**
     * Includes a field with an expression / operation value.
     *
     * @param string                    $field
     * @param ProjectOperationInterface $operation
     */
    public function includeOperationField($field, ProjectOperationInterface $operation)
    {
        $this->setField($field, $operation->getOperation());
    }
}
