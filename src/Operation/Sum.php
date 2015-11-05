<?php
namespace ConnectHolland\MongoAggregations\Operation;

/**
 * Operation to $sum in the $group stage
 *
 * @author Ron Rademaker
 */
class Sum
{
    /**
     * Creates a new condition
     */
    public function __construct()
    {
        $this->setOperationType('$push');
    }

    /**
     * Sets the value to sum
     *
     * @param mixed $sum
     */
    public function setSum($sum)
    {
        $this->setSum($sum);
    }
}
