<?php
namespace ConnectHolland\MongoAggregations\Builder;

use ConnectHolland\MongoAggregations\Aggregation\AggregationBag;
use ConnectHolland\MongoAggregations\Aggregation\AggregationInterface;

/**
 * Interface to create aggregation pipelines with
 *
 * @author Ron Rademaker
 */
interface BuilderInterface
{
    /**
     * Add an aggregation to the builder
     *
     * @param AggregationInterface
     */
    public function add(AggregationInterface $aggregation);

    /**
     * Add a bag of aggregations to the builder
     *
     * Note: the bag won't be emptied until the pipeline is build
     * Any changes there will be reflected in the resulting pipeline
     * 
     * @param AggregationBag
     */
    public function addBag(AggregationBag $bag);

    /**
     * Adds the aggragtions from another builder
     *
     * Note: the other builder won't actually build until this one does
     * Any changes there will be reflected in the resulting pipeline
     *
     * @param BuilderInterface
     */
    public function addBuilder(BuilderInterface $builder);

    /**
     * Builds the aggregation pipeline and return the array
     *
     * @return array
     */
    public function build();
}
