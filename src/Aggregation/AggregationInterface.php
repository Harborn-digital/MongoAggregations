<?php
namespace ConnectHolland\MongoAggregations\Aggregation;

/**
 * Interface defined a single stage in the aggrgation pipeline
 *
 * @author Ron Rademaker
 */
interface AggregationInterface
{
    /**
     * Retrieve this aggregation as accepted in a stage in the aggregate pipeline
     *
     * @return array
     */
    public function getStage();
}
