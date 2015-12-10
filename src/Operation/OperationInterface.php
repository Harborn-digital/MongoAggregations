<?php

namespace ConnectHolland\MongoAggregations\Operation;

/**
 * Interface for basic operation in the aggregation framework.
 *
 * @author Ron Rademaker
 */
interface OperationInterface
{
    /**
     * Retrieve this operation in array form acceptable by mongo.
     *
     * @return array
     */
    public function getOperation();
}
