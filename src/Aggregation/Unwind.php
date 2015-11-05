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
     * @param string $unwindField
     */
    public function setField($unwindField)
    {
        if (strpos($unwindField, '$') !== 0) {
            $unwindField = '$' . $unwindField;
        }
        
        $this->setDefinition($unwindField);
    }
}
