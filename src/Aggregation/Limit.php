<?php

namespace ConnectHolland\MongoAggregations\Aggregation;

/**
 * Represents an $limit aggregation stage in the pipeline.
 *
 * @author Jaap Romijn <jaap@connectholland.nl>
 */
class Limit extends AbstractAggregation
{
    /**
     * Creates a new limit aggregation object.
     *
     * @param number $limit
     */
    public function __construct($limit = null)
    {
        if (isset($limit)) {
            $this->setLimit($limit);
        }
        $this->setAggregationType('$limit');
    }

    /**
     * Sets the limit.
     *
     * @param number $limit
     */
    public function setLimit($limit)
    {
        $this->setDefinition(intval($limit));
    }
}
