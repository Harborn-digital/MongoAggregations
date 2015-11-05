<?php
namespace ConnectHolland\MongoAggregations\Builder;

use ConnectHolland\MongoAggregations\Aggregation\MixedFieldsBag;
use ConnectHolland\MongoAggregations\Aggregation\Unwind;

/**
 * Builder to create an unwind stage
 *
 * This builder allows you to use this in databases holding both arrays and other values in the same field
 * The use of this is discouraged both by Mongo and by me. Use this only if you must (i.e. libraries that must support these databases).
 *
 * @author Ron Rademaker
 */
class UnwindBuilder extends PipelineBuilder
{
    /**
     * Creates the unwind for $field
     *
     * @param string $field
     * @param boolean $allowMixedDatabases
     */
    public function __construct($field, $allowMixedDatabases = false)
    {
        if ($allowMixedDatabases === true) {
            $mixedFieldsBag = new MixedFieldsBag($field);
            $this->addBag($mixedFieldsBag);
        }

        $unwind = new Unwind();
        $unwind->setField($field);
        $this->add($unwind);
    }
}
