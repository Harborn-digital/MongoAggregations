<?php

namespace ConnectHolland\MongoAggregations\Aggregation;

/**
 * Represents an $skip aggregation stage in the pipeline.
 *
 * @author Jaap Romijn <jaap@connectholland.nl>
 */
class Skip extends AbstractAggregation
{
    /**
     * Creates a new Skip aggregation object.
     *
     * @param number $amount
     */
    public function __construct($amount = null)
    {
        if (isset($amount)) {
            $this->setAmount($amount);
        }
        $this->setAggregationType('$skip');
    }

    /**
     * Sets the amount.
     *
     * @param number $amount
     */
    public function setAmount($amount)
    {
        $this->setDefinition(intval($amount));
    }
}
