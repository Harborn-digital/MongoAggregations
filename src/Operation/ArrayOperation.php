<?php

namespace ConnectHolland\MongoAggregations\Operation;

/**
 * Multi purpose projection for unsupported projection operations
 *
 * @author Ron Rademaker
 */
class ArrayOperation implements ProjectOperationInterface
{
    /**
     * The operation in mongo array form
     *
     * @var array
     */
    private $operation;

    /**
     * Creates the operation for $operation
     * 
     * @param array $operation
     */
    public function __construct(array $operation)
    {
        $this->operation = $operation;
    }

    /**
     * Gets the operation
     *
     * @return array
     */
    public function getOperation()
    {
        return $this->operation;
    }
}
