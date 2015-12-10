<?php

namespace ConnectHolland\MongoAggregations\Aggregation;

/**
 * $sort stage.
 *
 * @author Ron Rademaker
 */
class Sort extends AbstractArrayDefinitionAggregation
{
    /**
     * Creates a new sort.
     */
    public function __construct()
    {
        $this->setAggregationType('$sort');
    }

    /**
     * Adds a sort field.
     *
     * @param string $field
     * @param int    $order
     */
    public function addSort($field, $order)
    {
        $this->setField($field, $order);
    }
}
