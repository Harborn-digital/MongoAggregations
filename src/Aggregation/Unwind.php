<?php
namespace ConnectHolland\MongoAggregations\Aggregation;

/**
 * Represents an $unwind aggregation stage in the pipeline
 *
 * @author Ron Rademaker
 */
class Unwind extends AbstractAggregation
{
    /**
     * Creates a new unwind
     *
     */
    public function __construct()
    {
        $this->setAggregationType('$unwind');
    }

    /**
     * Sets the field to unwind
     *
     * The $allowMixedDatabases allows you to use this in databases holding both arrays and other values in the same field
     * The use of this is discouraged both by Mongo and by me. Use this only if you must.
     *
     * @param string $unwindField
     */
    public function setField($unwindField)
    {
        $this->setDefinition($unwindField);
    }
}
