<?php

namespace ConnectHolland\MongoAggregations\Aggregation;

/**
 * Representation of a $match stage.
 *
 * @author Ron Rademaker
 */
class Match extends AbstractArrayDefinitionAggregation
{
    /**
     * Creates a new match.
     */
    public function __construct()
    {
        $this->setAggregationType('$match');
    }

    /**
     * Sets the query to match.
     *
     * @param array $query
     */
    public function setQuery(array $query)
    {
        $this->setDefinition($query);
    }
}
