<?php
namespace ConnectHolland\MongoAggregations\Builder;

use ConnectHolland\MongoAggregations\Aggregation\AggregationBag;
use ConnectHolland\MongoAggregations\Aggregation\AggregationInterface;

/**
 * Basic builder for aggegration pipelines
 *
 * @author Ron Rademaker
 */
class PipelineBuilder implements BuilderInterface
{
    /**
     * Array holding the pipeline parts
     *
     * @var array
     */
    private $pipeline = [];

    /**
     * Add an aggregation to the builder
     *
     * @param AggregationInterface
     */
    public function add(AggregationInterface $aggregation)
    {
        $this->pipeline[] = $aggregation;
    }

    /**
     * Add a bag of aggregations to the builder
     *
     * Note: the bag won't be emptied until the pipeline is build
     * Any changes there will be reflected in the resulting pipeline
     *
     * @param AggregationBag
     */
    public function addBag(AggregationBag $bag)
    {
        $this->pipeline[] = $bag;
    }

    /**
     * Adds the aggragtions from another builder
     *
     * Note: the other builder won't actually build until this one does
     * Any changes there will be reflected in the resulting pipeline
     *
     * @param BuilderInterface
     */
    public function addBuilder(BuilderInterface $builder)
    {
        $this->pipeline[] = $builder;
    }

    /**
     * Builds the aggregation pipeline and return the array
     *
     * @return array
     */
    public function build()
    {
        $aggregationPipeline = [];

        foreach ($this->pipeline as $part) {
            if ($part instanceof AggregationInterface) {
                $aggregationPipeline[] = $part;
            } elseif ($part instanceof AggregationBag) {
                $aggregations = $part->getBag();

                foreach ($aggregations as $aggregation) {
                    $aggregationPipeline[] = $aggregation;
                }
            } elseif ($part instanceof BuilderInterface) {
                $aggregations = $part->build();

                foreach ($aggregations as $aggregation) {
                    $aggregationPipeline[] = $aggregation;
                }
            }
        }

        return $aggregationPipeline;
    }
}