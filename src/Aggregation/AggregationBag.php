<?php

namespace ConnectHolland\MongoAggregations\Aggregation;

/**
 * A bag of related Aggregation stages that are useful together.
 *
 * @author Ron Rademaker
 */
class AggregationBag
{
    /**
     * Array holding the aggregations.
     */
    private $bag = [];

    /**
     * Adds an Aggregation stage to the bag.
     */
    public function addAggregation(AggregationInterface $aggregation)
    {
        $this->bag[] = $aggregation;
    }

    /**
     * Gets the aggregations in the bag.
     *
     * @return array
     */
    public function getBag()
    {
        return $this->bag;
    }
}
